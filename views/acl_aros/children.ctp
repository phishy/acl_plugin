<?php if ($node['AclAro']['lft']) { ?>
<option value="<?php print $node['AclAro']['parent_id'] ?>">..</option>
<?php } ?>
<option id="aro_editor_defaultParentId" value="<?php print $node['AclAro']['id'] ?>">.</option>
<?php foreach ($children as $c) { ?>
<option value="<?php print $c['AclAro']['id'] ?>">
  <?php print $c['AclAro']['alias'] ?>
  <?php if ($c['AclAro']['children']) print " ({$c['AclAro']['children']})" ?>
</option>
<?php } ?>