{**
* Prestashop module : Manualinvoicemanagement
*
* @author Progressio
* @copyright  Progressio
* @license Tous droits réservés / Le droit d'auteur s'applique (All rights reserved / French copyright law applies)
*}

{* <table>
	<tr>
		<td style="text-align: center; font-size: 6pt; color: #444">
			{$shop_address|escape:'htmlall':'UTF-8':'UTF-8'}<br />

			{if !empty($shop_phone) OR !empty($shop_fax)}
				{l s='For more assistance, contact Support:' mod='opartdevis'}<br />
				{if !empty($shop_phone)}
					Tel: {$shop_phone|escape:'htmlall':'UTF-8':'UTF-8'}
				{/if}

				{if !empty($shop_fax)}
					Fax: {$shop_fax|escape:'htmlall':'UTF-8':'UTF-8'}
				{/if}
				<br />
			{/if}

            {if isset($shop_details)}
                {$shop_details|escape:'htmlall':'UTF-8':'UTF-8'}<br />
            {/if}

            {if isset($free_text)}
    			{$free_text|escape:'htmlall':'UTF-8':'UTF-8'}<br />
            {/if}
		</td>
	</tr>
</table>
 *}