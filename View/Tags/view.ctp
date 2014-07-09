<div class="tags view">
<h2><?php echo __('Tag'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($tag['Tag']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tag'); ?></dt>
		<dd>
			<?php echo h($tag['Tag']['tag']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($tag['Tag']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($tag['Tag']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Tag'), array('action' => 'edit', $tag['Tag']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Tag'), array('action' => 'delete', $tag['Tag']['id']), array(), __('Are you sure you want to delete # %s?', $tag['Tag']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Tags'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tag'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Blogs'), array('controller' => 'blogs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Blog'), array('controller' => 'blogs', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Blogs'); ?></h3>
	<?php if (!empty($tag['Blog'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Text'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($tag['Blog'] as $blog): ?>
		<tr>
			<td><?php echo $blog['id']; ?></td>
			<td><?php echo $blog['title']; ?></td>
			<td><?php echo $blog['text']; ?></td>
			<td><?php echo $blog['created']; ?></td>
			<td><?php echo $blog['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'blogs', 'action' => 'view', $blog['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'blogs', 'action' => 'edit', $blog['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'blogs', 'action' => 'delete', $blog['id']), array(), __('Are you sure you want to delete # %s?', $blog['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Blog'), array('controller' => 'blogs', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
