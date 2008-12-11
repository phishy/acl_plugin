<?php print $javascript->link('/acl/js/prototype') ?>
<script>
function acl_aco_editor_load() {
	indicator_show();
	id = document.getElementById('aco_editor_parentId').value;
	new Ajax.Request('<?php print $html->url('/acl/aclAcos/load/') ?>' + id, { onSuccess: 
	function (transport) {
		data = eval("("+transport.responseText+")");
		document.getElementById('aco_editor_id').value = data.id;
		document.getElementById('aco_editor_originalParentId').value = data.parent_id;
		document.getElementById('aco_editor_alias').value = data.alias;
		document.getElementById('aco_editor_model').value = data.model;
		document.getElementById('aco_editor_foreignKey').value = data.key;
		document.getElementById('aco_editor_create').style.display = 'none';
		document.getElementById('aco_editor_update').style.display = 'inline';
		document.getElementById('aco_editor_cancel').style.display = 'inline';
		document.getElementById('aco_editor_delete').style.display = 'inline';
		indicator_hide();
	}});
}
function acl_aco_editor_children(id) {
	indicator_show();
	new Ajax.Updater({success:'aco_editor_parentId'}, '<?php print $html->url('/acl/aclAcos/children/') ?>' + id, 
	{
		method:'get',
		onSuccess: function() {
			indicator_hide();
		}
	});
}
function acl_aco_editor_reload() {
	indicator_show();
	new Ajax.Updater('aco_editor_parentId', '<?php print $html->url('/acl/aclAcos/children', true) ?>',
	{
		onSuccess: function() {
			indicator_hide();
		}
	});
}
function acl_aco_editor_delete() {
	indicator_show();
	id = document.getElementById('aco_editor_parentId').value;
	new Ajax.Request('<?php print $html->url('/acl/aclAcos/delete/') ?>' + id, {onSuccess:
	function() {
		acl_aco_editor_children($('aco_editor_originalParentId').value);
		acl_aco_editor_cancel();
		indicator_hide();
	}});
	
}
function acl_aco_editor_cancel() {
	document.getElementById('aco_editor_id').value = '';
	document.getElementById('aco_editor_parentId').value = '';
	document.getElementById('aco_editor_alias').value = '';
	document.getElementById('aco_editor_foreignKey').value = '';
	document.getElementById('aco_editor_model').value = '';
	document.getElementById('aco_editor_create').style.display= 'inline';
	document.getElementById('aco_editor_update').style.display = 'none';
	document.getElementById('aco_editor_cancel').style.display = 'none';
	document.getElementById('aco_editor_delete').style.display = 'none';
}
function acl_aco_editor_create() {
	indicator_show();
	parent_id = document.getElementById('aco_editor_parentId').value;
	alias     = $('aco_editor_alias').value;
	key       = document.getElementById('aco_editor_foreignKey').value;
	model     = document.getElementById('aco_editor_model').value;
	if (!parent_id) {
		parent_id = $('aco_editor_defaultParentId').value;
	}
	h = new Hash({'data[AclAco][alias]':alias, 'data[AclAco][foreign_key]':key, 'data[AclAco][model]':model, 'data[AclAco][parent_id]':parent_id});
	new Ajax.Request('<?php print $html->url('/acl/aclAcos/add', true) ?>', {parameters: h, onSuccess: 
	function() {
		acl_aco_editor_children(parent_id); 
		acl_aco_editor_cancel();
		indicator_hide();
	} });
}
function acl_aco_editor_update() {
	indicator_show();
	id        = document.getElementById('aco_editor_id').value;
	parent_id = document.getElementById('aco_editor_parentId').value;
	alias     = document.getElementById('aco_editor_alias').value;
	key       = document.getElementById('aco_editor_foreignKey').value;
	model     = document.getElementById('aco_editor_model').value;
	if (parent_id != id) {
		h = new Hash({'data[AclAco][id]':id, 'data[AclAco][alias]':alias, 'data[AclAco][foreign_key]':key, 'data[AclAco][model]':model, 'data[AclAco][parent_id]':parent_id});
	} else {
		h = new Hash({'data[AclAco][id]':id, 'data[AclAco][alias]':alias, 'data[AclAco][foreign_key]':key, 'data[AclAco][model]':model});
	}
	new Ajax.Request('<?php print $html->url('/acl/aclAcos/update', true) ?>', {parameters: h, onSuccess: 
	function() {
		acl_aco_editor_children($('aco_editor_parentId').value); 
		acl_aco_editor_cancel();
		indicator_hide();
	} });
}
function indicator_show() {
	$('indicator').show();
}
function indicator_hide() {
	$('indicator').hide();
}
function setup() {
	acl_aco_editor_reload();
}
</script>
<?php print $this->renderElement('acl_menu') ?>
<div>
  <?php print $html->image('/acl/img/tango/32x32/apps/preferences-system-windows.png', array('align' => 'absmiddle')) ?>
  <b>Manage Acos</b>
  <span id="indicator" style="display:none;"><?php print $html->image('indicator.gif') ?> Loading.</span>
</div>
<table>
  <tr>
    <td>
      <select id="aco_editor_parentId" class="acl_select" size="10" ondblclick="acl_aco_editor_children(this.value)">
		<option>Empty</option>
      </select>
      <input type="button" value="Edit" onClick="acl_aco_editor_load()">
    </td>
    <td>
      <table>
        <tr>
          <td>Alias</td>
          <td><input id="aco_editor_alias" type="text"></td>
        </tr>
        <tr>
          <td>Model</td>
          <td><input id="aco_editor_model" type="text"></td>
        </tr>
        <tr>
          <td>Key</td>
          <td><input id="aco_editor_foreignKey" type="text"></td>
        </tr>
      </table>
      <input id="aco_editor_id" type="hidden">
      <input id="aco_editor_originalParentId" type="hidden">
      <input id="aco_editor_create" type="button" value="Create" onClick="acl_aco_editor_create()">
      <input id="aco_editor_cancel" type="button" value="Cancel" onClick="acl_aco_editor_cancel()" style="display:none">
      <input id="aco_editor_update" type="button" value="Update" onClick="acl_aco_editor_update()" style="display:none">
      <input id="aco_editor_delete" type="button" value="Delete" onClick="acl_aco_editor_delete()" style="display:none">
    </td>
  </tr>
</table>
<script>setup();</script>
      