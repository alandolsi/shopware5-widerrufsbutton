{extends file="parent:frontend/index/footer_typ_1.tpl"}

{* Append the legally required "Vertrag widerrufen" link to the footer service menu (§ 356a BGB). *}
{block name="frontend_index_footer_column_service_menu_after" append}
    <li class="navigation--entry landolsi-widerruf--footer-entry" role="menuitem">
        <a class="btn is--primary landolsi-widerruf--footer-btn"
           href="{url controller='Widerruf' action='index'}"
           title="{s name='FooterLink' namespace='frontend/landolsi_widerruf/index'}Vertrag widerrufen{/s}">
            {s name='FooterLink' namespace='frontend/landolsi_widerruf/index'}Vertrag widerrufen{/s}
        </a>
    </li>
{/block}
