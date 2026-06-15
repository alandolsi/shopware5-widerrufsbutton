{extends file='frontend/index/index.tpl'}

{block name='frontend_index_header_title'}{s name='ConfirmHeadline' namespace='frontend/landolsi_widerruf/index'}Widerruf bestätigen{/s} | {$smarty.block.parent}{/block}

{block name='frontend_index_content'}
    <div class="content--wrapper">
        <div class="content widerruf--content" role="main">

            <div class="panel has--border is--rounded landolsi-widerruf">
                <h1 class="panel--title is--underline">
                    {s name='ConfirmHeadline' namespace='frontend/landolsi_widerruf/index'}Widerruf bestätigen{/s}
                </h1>

                <div class="panel--body is--wide">
                    <p class="landolsi-widerruf--intro">
                        {s name='ConfirmIntro' namespace='frontend/landolsi_widerruf/index'}Bitte prüfen Sie Ihre Angaben. Mit Klick auf „Widerruf bestätigen“ geben Sie Ihre Widerrufserklärung verbindlich ab.{/s}
                    </p>

                    <dl class="landolsi-widerruf--summary">
                        <dt>{s name='LabelName' namespace='frontend/landolsi_widerruf/index'}Name{/s}</dt>
                        <dd>{$formData.name|escape}</dd>

                        <dt>{s name='LabelEmail' namespace='frontend/landolsi_widerruf/index'}E-Mail-Adresse{/s}</dt>
                        <dd>{$formData.email|escape}</dd>

                        {if $formData.orderNumber}
                            <dt>{s name='LabelOrderNumber' namespace='frontend/landolsi_widerruf/index'}Bestell- / Vertragsnummer (sofern vorhanden){/s}</dt>
                            <dd>{$formData.orderNumber|escape}</dd>
                        {/if}

                        {if $formData.contractInfo}
                            <dt>{s name='LabelContractInfo' namespace='frontend/landolsi_widerruf/index'}Welchen Vertrag möchten Sie widerrufen?{/s}</dt>
                            <dd>{$formData.contractInfo|escape|nl2br}</dd>
                        {/if}
                    </dl>

                    <form name="widerrufConfirm" method="post"
                          action="{url controller='Widerruf' action='submit'}"
                          class="landolsi-widerruf--confirm-form">
                        <input type="hidden" name="name" value="{$formData.name|escape}"/>
                        <input type="hidden" name="email" value="{$formData.email|escape}"/>
                        <input type="hidden" name="orderNumber" value="{$formData.orderNumber|escape}"/>
                        <input type="hidden" name="contractInfo" value="{$formData.contractInfo|escape}"/>

                        <div class="landolsi-widerruf--actions">
                            <a href="{url controller='Widerruf' action='index'}" class="btn is--secondary landolsi-widerruf--back">
                                {s name='ButtonBack' namespace='frontend/landolsi_widerruf/index'}Zurück / Ändern{/s}
                            </a>
                            <button type="submit" class="btn is--primary is--large landolsi-widerruf--confirm">
                                {s name='ButtonConfirm' namespace='frontend/landolsi_widerruf/index'}Widerruf bestätigen{/s}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
{/block}
