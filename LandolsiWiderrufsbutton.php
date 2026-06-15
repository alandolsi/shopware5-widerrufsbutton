<?php

namespace LandolsiWiderrufsbutton;

use Doctrine\ORM\Tools\SchemaTool;
use LandolsiWiderrufsbutton\Models\Widerruf;
use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\DeactivateContext;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;

/**
 * Widerrufsbutton (§ 356a BGB) — Landolsi Webdesign. MIT License.
 */
class LandolsiWiderrufsbutton extends Plugin
{
    /**
     * Register the plugin's Resources/views in the theme inheritance so template
     * extensions ({extends file="parent:..."}) work — also for themes that override
     * footer templates (e.g. CleanTheme's footer_typ_1.tpl).
     */
    public function hasAutoloadViews(): bool
    {
        return true;
    }

    public function install(InstallContext $context)
    {
        $this->createDatabaseSchema();
        $this->createMailTemplate();
        $context->scheduleClearCache(InstallContext::CACHE_LIST_ALL);
    }

    public function activate(ActivateContext $context)
    {
        $context->scheduleClearCache(ActivateContext::CACHE_LIST_ALL);
    }

    public function deactivate(DeactivateContext $context)
    {
        $context->scheduleClearCache(DeactivateContext::CACHE_LIST_ALL);
    }

    public function uninstall(UninstallContext $context)
    {
        // Keep customer/withdrawal data unless the admin explicitly chose to remove it.
        if (!$context->keepUserData()) {
            $this->removeDatabaseSchema();
            $this->removeMailTemplate();
        }
        $context->scheduleClearCache(UninstallContext::CACHE_LIST_ALL);
    }

    private function createDatabaseSchema()
    {
        $entityManager = $this->container->get('models');
        $schemaTool = new SchemaTool($entityManager);
        $classMetadata = [$entityManager->getClassMetadata(Widerruf::class)];

        try {
            // saveMode = true: only additive changes, never drops existing data.
            $schemaTool->updateSchema($classMetadata, true);
        } catch (\Exception $e) {
            // Table already exists — nothing to do.
        }
    }

    private function removeDatabaseSchema()
    {
        $entityManager = $this->container->get('models');
        $schemaTool = new SchemaTool($entityManager);
        $classMetadata = [$entityManager->getClassMetadata(Widerruf::class)];

        try {
            $schemaTool->dropSchema($classMetadata);
        } catch (\Exception $e) {
            // Ignore — table may already be gone.
        }
    }

    /**
     * Creates the "withdrawal received" confirmation mail template if it does not exist yet.
     */
    private function createMailTemplate()
    {
        $connection = $this->container->get('dbal_connection');

        $exists = $connection->fetchColumn(
            'SELECT id FROM s_core_config_mails WHERE name = ?',
            ['sLANDOLSIWIDERRUFCONFIRM']
        );

        if ($exists) {
            return;
        }

        $subject = 'Eingangsbestätigung Ihres Widerrufs';

        $content = "Sehr geehrte/r {\$name},\n\n"
            . "wir bestätigen den Eingang Ihrer Widerrufserklärung.\n\n"
            . "Eingegangen am: {\$dateFormatted}\n"
            . "{if \$orderNumber}Bestell-/Vertragskennung: {\$orderNumber}\n{/if}"
            . "\nIhre Erklärung wird gemäß den gesetzlichen Vorgaben bearbeitet. "
            . "Über die Rückabwicklung informieren wir Sie gesondert.\n\n"
            . "Diese E-Mail dient als Eingangsbestätigung auf einem dauerhaften Datenträger.\n\n"
            . "Mit freundlichen Grüßen\n"
            . "{config name=shopName}";

        $contentHtml = "<p>Sehr geehrte/r {\$name},</p>"
            . "<p>wir bestätigen den Eingang Ihrer Widerrufserklärung.</p>"
            . "<p><strong>Eingegangen am:</strong> {\$dateFormatted}<br/>"
            . "{if \$orderNumber}<strong>Bestell-/Vertragskennung:</strong> {\$orderNumber}{/if}</p>"
            . "<p>Ihre Erklärung wird gemäß den gesetzlichen Vorgaben bearbeitet. "
            . "Über die Rückabwicklung informieren wir Sie gesondert.</p>"
            . "<p>Diese E-Mail dient als Eingangsbestätigung auf einem dauerhaften Datenträger.</p>"
            . "<p>Mit freundlichen Grüßen<br/>{config name=shopName}</p>";

        $connection->insert('s_core_config_mails', [
            'name'        => 'sLANDOLSIWIDERRUFCONFIRM',
            'frommail'    => '{config name=mail}',
            'fromname'    => '{config name=shopName}',
            'subject'     => $subject,
            'content'     => $content,
            'contentHTML' => $contentHtml,
            'ishtml'      => 1,
            'mailtype'    => 1,
            'dirty'       => 0,
        ]);
    }

    private function removeMailTemplate()
    {
        $connection = $this->container->get('dbal_connection');
        $connection->delete('s_core_config_mails', ['name' => 'sLANDOLSIWIDERRUFCONFIRM']);
    }
}
