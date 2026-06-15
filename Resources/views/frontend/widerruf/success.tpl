{extends file='frontend/index/index.tpl'}

{block name='frontend_index_header_title'}{s name='SuccessHeadline' namespace='frontend/landolsi_widerruf/index'}Widerruf eingegangen{/s} | {$smarty.block.parent}{/block}

{block name='frontend_index_content'}
    <div class="content--wrapper">
        <div class="content widerruf--content" role="main">

            <div class="panel has--border is--rounded landolsi-widerruf">
                <h1 class="panel--title is--underline">
                    {s name='SuccessHeadline' namespace='frontend/landolsi_widerruf/index'}Widerruf eingegangen{/s}
                </h1>

                <div class="panel--body is--wide">
                    <div class="alert is--success is--rounded" role="status">
                        {s name='SuccessMessage' namespace='frontend/landolsi_widerruf/index'}Vielen Dank. Wir haben Ihren Widerruf erhalten und Ihnen eine Eingangsbestätigung mit Datum und Uhrzeit per E-Mail gesendet.{/s}
                    </div>

                    <p>
                        <a href="{url controller='index'}" class="btn is--primary">
                            {s name='ButtonHome' namespace='frontend/landolsi_widerruf/index'}Zur Startseite{/s}
                        </a>
                    </p>
                </div>
            </div>

        </div>
    </div>
{/block}
