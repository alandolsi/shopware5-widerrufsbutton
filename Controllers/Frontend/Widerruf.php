<?php

use LandolsiWiderrufsbutton\Models\Widerruf;

/**
 * Frontend controller for the legally required right-of-withdrawal function (§ 356a BGB).
 *
 * Flow (two stages as required by § 356a):
 *   indexAction   GET  -> show the withdrawal form
 *   confirmAction POST -> validate, show review page with the "Widerruf bestätigen" button
 *   submitAction  POST -> validate again, store, send confirmation + notification mails
 *   successAction GET  -> success page
 */
class Shopware_Controllers_Frontend_Widerruf extends Enlight_Controller_Action
{
    public function indexAction()
    {
        $this->View()->assign('formData', $this->prefillData());
        $this->View()->assign('errors', []);
    }

    public function confirmAction()
    {
        if (!$this->Request()->isPost()) {
            $this->redirect(['controller' => 'Widerruf', 'action' => 'index']);
            return;
        }

        $data = $this->collectInput();
        $errors = $this->validate($data);

        if (!empty($errors)) {
            $this->View()->assign('formData', $data);
            $this->View()->assign('errors', $errors);
            $this->View()->loadTemplate('frontend/widerruf/index.tpl');
            return;
        }

        $this->View()->assign('formData', $data);
    }

    public function submitAction()
    {
        if (!$this->Request()->isPost()) {
            $this->redirect(['controller' => 'Widerruf', 'action' => 'index']);
            return;
        }

        $data = $this->collectInput();
        $errors = $this->validate($data);

        if (!empty($errors)) {
            $this->View()->assign('formData', $data);
            $this->View()->assign('errors', $errors);
            $this->View()->loadTemplate('frontend/widerruf/index.tpl');
            return;
        }

        $record = $this->persist($data);

        $sent = $this->sendConfirmationMail($data, $record->getCreatedAt());
        if ($sent) {
            $record->setConfirmationSent(true);
            $this->container->get('models')->flush($record);
        }
        $this->sendShopNotification($data, $record);

        $this->redirect(['controller' => 'Widerruf', 'action' => 'success']);
    }

    public function successAction()
    {
        // Renders frontend/widerruf/success.tpl
    }

    /**
     * @return array
     */
    private function collectInput()
    {
        $request = $this->Request();

        return [
            'name'         => trim((string) $request->getParam('name', '')),
            'email'        => trim((string) $request->getParam('email', '')),
            'orderNumber'  => trim((string) $request->getParam('orderNumber', '')),
            'contractInfo' => trim((string) $request->getParam('contractInfo', '')),
        ];
    }

    /**
     * @param array $data
     * @return array map of field => error snippet key
     */
    private function validate(array $data)
    {
        $errors = [];

        if ($data['name'] === '') {
            $errors['name'] = 'errorName';
        }
        if ($data['email'] === '' || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'errorEmail';
        }

        return $errors;
    }

    /**
     * Pre-fill the form for logged-in customers (convenience). Never required.
     *
     * @return array
     */
    private function prefillData()
    {
        $data = ['name' => '', 'email' => '', 'orderNumber' => '', 'contractInfo' => ''];

        $userId = (int) $this->container->get('session')->get('sUserId');
        if ($userId <= 0) {
            return $data;
        }

        try {
            $connection = $this->container->get('dbal_connection');
            $row = $connection->fetchAssoc(
                'SELECT u.email, a.firstname, a.lastname
                 FROM s_user u
                 LEFT JOIN s_user_addresses a ON a.id = u.default_billing_address_id
                 WHERE u.id = ?',
                [$userId]
            );
            if ($row) {
                $data['email'] = (string) $row['email'];
                $data['name'] = trim(((string) $row['firstname']) . ' ' . ((string) $row['lastname']));
            }
        } catch (\Exception $e) {
            // Pre-fill is best-effort only.
        }

        return $data;
    }

    /**
     * @param array $data
     * @return Widerruf
     */
    private function persist(array $data)
    {
        $entityManager = $this->container->get('models');

        $record = new Widerruf();
        $record->setCreatedAt(new \DateTime());
        $record->setName($data['name']);
        $record->setEmail($data['email']);
        $record->setOrderNumber($data['orderNumber'] !== '' ? $data['orderNumber'] : null);
        $record->setContractInfo($data['contractInfo'] !== '' ? $data['contractInfo'] : null);

        $userId = (int) $this->container->get('session')->get('sUserId');
        $record->setCustomerId($userId > 0 ? $userId : null);

        if ($this->container->initialized('shop') && $this->container->get('shop')) {
            $record->setShopId((int) $this->container->get('shop')->getId());
        }

        $record->setIpAddress($this->clientIp());

        $entityManager->persist($record);
        $entityManager->flush($record);

        return $record;
    }

    /**
     * Sends the legally required receipt confirmation to the consumer (durable medium).
     *
     * @return bool
     */
    private function sendConfirmationMail(array $data, \DateTime $createdAt)
    {
        try {
            $context = [
                'name'          => $data['name'],
                'orderNumber'   => $data['orderNumber'],
                'contractInfo'  => $data['contractInfo'],
                'dateFormatted' => $createdAt->format('d.m.Y H:i'),
            ];

            $mail = $this->container->get('templatemail')->createMail('sLANDOLSIWIDERRUFCONFIRM', $context);
            $mail->addTo($data['email']);
            $mail->send();

            return true;
        } catch (\Exception $e) {
            $this->container->get('corelogger')->error(
                'LandolsiWiderrufsbutton: confirmation mail failed: ' . $e->getMessage()
            );
            return false;
        }
    }

    /**
     * Notifies the shop operator about the new withdrawal so it can be processed.
     */
    private function sendShopNotification(array $data, Widerruf $record)
    {
        try {
            $shopMail = $this->resolveNotificationEmail();
            if ($shopMail === '') {
                return;
            }

            $body = "Es ist ein neuer Widerruf eingegangen.\n\n"
                . 'Eingegangen am: ' . $record->getCreatedAt()->format('d.m.Y H:i') . "\n"
                . 'Name: ' . $data['name'] . "\n"
                . 'E-Mail: ' . $data['email'] . "\n"
                . 'Bestell-/Vertragskennung: ' . ($data['orderNumber'] !== '' ? $data['orderNumber'] : '-') . "\n"
                . 'Angaben zum Vertrag: ' . ($data['contractInfo'] !== '' ? $data['contractInfo'] : '-') . "\n"
                . 'Interne ID: ' . $record->getId() . "\n";

            $mail = clone $this->container->get('mail');
            $mail->clearRecipients();
            $mail->clearSubject();
            $mail->setSubject('Neuer Widerruf eingegangen (#' . $record->getId() . ')');
            $mail->setBodyText($body);
            $mail->addTo($shopMail);
            $mail->send();
        } catch (\Exception $e) {
            $this->container->get('corelogger')->error(
                'LandolsiWiderrufsbutton: shop notification failed: ' . $e->getMessage()
            );
        }
    }

    /**
     * Notification target: plugin config "notificationEmail" if set, otherwise the shop e-mail.
     *
     * @return string
     */
    private function resolveNotificationEmail()
    {
        try {
            $config = $this->container->get('shopware.plugin.cached_config_reader')
                ->getByPluginName('LandolsiWiderrufsbutton');
            if (!empty($config['notificationEmail'])) {
                return trim((string) $config['notificationEmail']);
            }
        } catch (\Exception $e) {
            // Fall back to the shop e-mail.
        }

        return (string) $this->container->get('config')->get('mail');
    }

    /**
     * @return string|null
     */
    private function clientIp()
    {
        try {
            return $this->container->get('shopware.components.privacy.ip_anonymizer')
                ->anonymize($this->Request()->getClientIp());
        } catch (\Exception $e) {
            return $this->Request()->getClientIp();
        }
    }
}
