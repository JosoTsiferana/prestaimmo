{**
* Prestashop module : Manualinvoicemanagement
*
* @author Progressio
* @copyright  Progressio
* @license Tous droits réservés / Le droit d'auteur s'applique (All rights reserved / French copyright law applies)
*}

<a href="{$href|escape:'html':'UTF-8'}"{if isset($confirm)} onclick="if (confirm('{$confirm}')){ldelim}return true;{rdelim}else{ldelim}event.stopPropagation(); event.preventDefault();{rdelim};"{/if} title="{$action|escape:'html':'UTF-8'}" >
	<i class="icon-pencil"></i> {$action|escape:'html':'UTF-8'}
</a>
