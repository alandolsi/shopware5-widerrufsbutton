{extends file='frontend/index/index.tpl'}

{block name='frontend_index_header_title'}{s name='FormHeadline' namespace='frontend/landolsi_widerruf/index'}Vertrag widerrufen{/s} | {$smarty.block.parent}{/block}

{block name='frontend_index_content'}
    <div class="content--wrapper">
        <div class="content widerruf--content" role="main">

            <div class="panel has--border is--rounded landolsi-widerruf">
                <h1 class="panel--title is--underline">
                    {s name='FormHeadline' namespace='frontend/landolsi_widerruf/index'}Vertrag widerrufen{/s}
                </h1>

                <div class="panel--body is--wide">
                    <p class="landolsi-widerruf--intro">
                        {s name='FormIntro' namespace='frontend/landolsi_widerruf/index'}Hier können Sie einen mit uns geschlossenen Vertrag widerrufen. Füllen Sie das Formular aus und bestätigen Sie Ihren Widerruf im nächsten Schritt. Sie erhalten anschließend eine Eingangsbestätigung per E-Mail.{/s}
                    </p>

                    {if $errors|@count > 0}
                        <div class="alert is--error is--rounded" role="alert">
                            {s name='ErrorIntro' namespace='frontend/landolsi_widerruf/index'}Bitte korrigieren Sie die markierten Felder.{/s}
                        </div>
                    {/if}

                    <form name="widerruf" method="post"
                          action="{url controller='Widerruf' action='confirm'}"
                          class="landolsi-widerruf--form">

                        <div class="landolsi-widerruf--field">
                            <label for="widerruf-name" class="landolsi-widerruf--label">
                                {s name='LabelName' namespace='frontend/landolsi_widerruf/index'}Name{/s} *
                            </label>
                            <input type="text" id="widerruf-name" name="name" required
                                   value="{$formData.name|escape}"
                                   class="landolsi-widerruf--input{if $errors.name} has--error{/if}"/>
                            {if $errors.name}<span class="landolsi-widerruf--error">{s name='ErrorName' namespace='frontend/landolsi_widerruf/index'}Bitte geben Sie Ihren Namen an.{/s}</span>{/if}
                        </div>

                        <div class="landolsi-widerruf--field">
                            <label for="widerruf-email" class="landolsi-widerruf--label">
                                {s name='LabelEmail' namespace='frontend/landolsi_widerruf/index'}E-Mail-Adresse{/s} *
                            </label>
                            <input type="email" id="widerruf-email" name="email" required
                                   value="{$formData.email|escape}"
                                   class="landolsi-widerruf--input{if $errors.email} has--error{/if}"/>
                            {if $errors.email}<span class="landolsi-widerruf--error">{s name='ErrorEmail' namespace='frontend/landolsi_widerruf/index'}Bitte geben Sie eine gültige E-Mail-Adresse an.{/s}</span>{/if}
                        </div>

                        <div class="landolsi-widerruf--field">
                            <label for="widerruf-ordernumber" class="landolsi-widerruf--label">
                                {s name='LabelOrderNumber' namespace='frontend/landolsi_widerruf/index'}Bestell- / Vertragsnummer (sofern vorhanden){/s}
                            </label>
                            <input type="text" id="widerruf-ordernumber" name="orderNumber"
                                   value="{$formData.orderNumber|escape}"
                                   class="landolsi-widerruf--input"/>
                        </div>

                        <div class="landolsi-widerruf--field">
                            <label for="widerruf-contract" class="landolsi-widerruf--label">
                                {s name='LabelContractInfo' namespace='frontend/landolsi_widerruf/index'}Welchen Vertrag möchten Sie widerrufen?{/s}
                            </label>
                            <textarea id="widerruf-contract" name="contractInfo" rows="3"
                                      class="landolsi-widerruf--input">{$formData.contractInfo|escape}</textarea>
                        </div>

                        <p class="landolsi-widerruf--hint">
                            {s name='NoReasonHint' namespace='frontend/landolsi_widerruf/index'}Eine Angabe von Gründen ist nicht erforderlich.{/s}
                        </p>

                        <div class="landolsi-widerruf--actions">
                            <button type="submit" class="btn is--primary is--large landolsi-widerruf--submit">
                                {s name='ButtonNext' namespace='frontend/landolsi_widerruf/index'}Weiter{/s}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
{/block}
