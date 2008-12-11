<?php print $javascript->link('/acl/js/prototype') ?>
<script>
function acl_aro_editor_load() {
	indicator_show();
	id = $('aro_editor_parentId').value;
	new Ajax.Request('<?php print $html->url('/acl/aclAros/load/') ?>' + id, { onSuccess: 
	function (transport) {
		data = eval("("+transport.responseText+")");
		$('aro_editor_id').value = data.id;
		$('aro_editor_originalParentId').value = data.parent_id;
		$('aro_editor_alias').value = data.alias;
		$('aro_editor_model').value = data.model;
		$('aro_editor_foreignKey').value = data.key;
		$('aro_editor_create').hide();
		$('aro_editor_update').show();
		$('aro_editor_cancel').show();
		$('aro_editor_delete').show();
		indicator_hide();
	}});
}
function acl_aro_editor_children(id) {
	indicator_show();
	new Ajax.Updater({success:'aro_editor_parentId'}, '<?php print $html->url('/acl/aclAros/children/') ?>' + id, 
	{
		method:'get',
		onSuccess: function() {
			indicator_hide();
		}
	});
}
function acl_aro_editor_reload() {
	indicator_show();
	new Ajax.Updater('aro_editor_parentId', '<?php print $html->url('/acl/aclAros/children', true) ?>', 
	{
		onSuccess:
			function() {
				indicator_hide();
			}
	});
}
function acl_aro_editor_delete() {
	indicator_show();
	id = $('aro_editor_parentId').value;
	new Ajax.Request('<?php print $html->url('/acl/aclAros/delete/') ?>' + id, {onSuccess:
	function() {
		acl_aro_editor_children($('aro_editor_originalParentId').value);
		acl_aro_editor_cancel();
		indicator_hide();
	}});
	
}
function acl_aro_editor_cancel() {
	$('aro_editor_id').value = '';
	$('aro_editor_parentId').value = '';
	$('aro_editor_alias').value = '';
	$('aro_editor_foreignKey').value = '';
	$('aro_editor_model').value = '';
	$('aro_editor_create').show();
	$('aro_editor_update').hide();
	$('aro_editor_cancel').hide();
	$('aro_editor_delete').hide();
}
function acl_aro_editor_create() {
	indicator_show();
	parent_id = $('aro_editor_parentId').value;
	alias     = $('aro_editor_alias').value;
	key       = $('aro_editor_foreignKey').value;
	model     = $('aro_editor_model').value;
	if (!parent_id) {
		parent_id = $('aro_editor_defaultParentId').value;
	}
	h = new Hash({'data[AclAro][alias]':alias, 'data[AclAro][foreign_key]':key, 'data[AclAro][model]':model, 'data[AclAro][parent_id]':parent_id});
	new Ajax.Request('<?php print $html->url('/acl/aclAros/add', true) ?>', {parameters: h, onSuccess: 
	function() {
		acl_aro_editor_children(parent_id); 
		acl_aro_editor_cancel();
		indicator_hide();
	} });
}
function acl_aro_editor_update() {
	indicator_show();
	id        = $('aro_editor_id').value;
	parent_id = $('aro_editor_parentId').value;
	alias     = $('aro_editor_alias').value;
	key       = $('aro_editor_foreignKey').value;
	model     = $('aro_editor_model').value;
	if (parent_id != id) {
		h = new Hash({'data[AclAro][id]':id, 'data[AclAro][alias]':alias, 'data[AclAro][foreign_key]':key, 'data[AclAro][model]':model, 'data[AclAro][parent_id]':parent_id});
	} else {
		h = new Hash({'data[AclAro][id]':id, 'data[AclAro][alias]':alias, 'data[AclAro][foreign_key]':key, 'data[AclAro][model]':model});
	}
	new Ajax.Request('<?php print $html->url('/acl/aclAros/update', true) ?>', 
	{
		parameters: h, 
		onSuccess: 
			function () {
			    acl_aro_editor_children($('aro_editor_parentId').value);
				acl_aro_editor_cancel();
				indicator_hide();
			}
	}) 
}
function indicator_show() {
	$('indicator').show();
}
function indicator_hide() {
	$('indicator').hide();
}
function setup() {
	acl_aro_editor_reload();
}
</script>
<?php print $this->renderElement('acl_menu') ?>
<div>
  <?php print $html->image('/acl/img/tango/32x32/apps/system-users.png', array('align' => 'absmiddle')) ?>
  <b>Manage Aros</b>
  <span id="indicator" style="display:none;"><?php print $html->image('indicator.gif') ?> Loading.</span>
</div>
<table>
  <tr>
    <td>
      <select id="aro_editor_parentId" class="acl_select" size="10" ondblclick="acl_aro_editor_children(this.value)">
		<option>Empty</option>
      </select>
      <input type="button" value="Edit" onClick="acl_aro_editor_load()">
    </td>
    <td>
      <table>
        <tr>
          <td>Alias</td>
          <td><input id="aro_editor_alias" type="text"></td>
        </tr>
        <tr>
          <td>Model</td>
          <td><input id="aro_editor_model" type="text"></td>
        </tr>
        <tr>
          <td>Key</td>
          <td><input id="aro_editor_foreignKey" type="text"></td>
        </tr>
      </table>
      <input id="aro_editor_id" type="hidden">
      <input id="aro_editor_originalParentId" type="hidden">
      <input id="aro_editor_create" type="button" value="Create" onClick="acl_aro_editor_create()">
      <input id="aro_editor_cancel" type="button" value="Cancel" onClick="acl_aro_editor_cancel()" style="display:none">
      <input id="aro_editor_update" type="button" value="Update" onClick="acl_aro_editor_update()" style="display:none">
      <input id="aro_editor_delete" type="button" value="Delete" onClick="acl_aro_editor_delete()" style="display:none">
    </td>
  </tr>
</table>
<script>setup();</script>