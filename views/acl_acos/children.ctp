<?php if ($node['AclAco']['lft']) { ?>
<option value="<?php print $node['AclAco']['parent_id'] ?>">..</option>
<?php } ?>
<option id="aco_editor_defaultParentId" value="<?php print $node['AclAco']['id'] ?>">.</option>
<?php foreach ($children as $c) { ?>
<option value="<?php print $c['AclAco']['id'] ?>">
  <?php print $c['AclAco']['alias'] ?>
  <?php if ($c['AclAco']['children']) print " ({$c['AclAco']['children']})" ?>
</option>
<?php } ?>
