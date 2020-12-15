<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="row">
	<div class="col-12">

<h2>ISO Data for your application(s)</h2>
		<p>
This is the export interface where you can get the current version of the tables.<br/>
Please help to keep it up to date. You can submit changes via issue/PR on the <a href="https://github.com/dereuromark/cakephp-data" target="_blank">repo</a>.<br/>
An interface to directly modify the data is planned, though.
		</p>

	</div>
</div>

<div class="row">
	<div class="col-md-6 col-12">

<h3><?php echo __('Continents'); ?>/<?php echo __('Regions');?></h3>
<div>Key information: code, nested regions and subregions as tree</div>
<?php echo $this->Html->link(__('View online'), ['plugin'=>'Data', 'controller' => 'Continents', 'action' => 'index']); ?>
<ul>
<li><?php echo $this->Html->link('JSON', ['action' => 'continents', '_ext' => 'json']); ?></li>
<li><?php echo $this->Html->link('XML', ['action' => 'continents', '_ext' => 'xml']); ?></li>
</ul>

<h3><?php echo __('Countries'); ?></h3>
<div>Key information: lat/lng, ISO codes, zip code length/regexp, eu member, address_format, country_code, timezone</div>
<?php echo $this->Html->link(__('View online'), ['plugin' => 'Data', 'controller' => 'countries', 'action' => 'index']); ?>
<ul>
<li><?php echo $this->Html->link('JSON', ['action' => 'countries', '_ext' => 'json']); ?></li>
<li><?php echo $this->Html->link('XML', ['action' => 'countries', '_ext' => 'xml']); ?></li>
</ul>

<h3><?php echo __('States'); ?></h3>
<div>Key information: lat/lng, ISO codes</div>
<?php echo $this->Html->link(__('View online'), ['plugin' => 'Data', 'controller' => 'states', 'action' => 'index']); ?>
<ul>
<li><?php echo $this->Html->link('JSON', ['action' => 'states', '_ext' => 'json']); ?></li>
<li><?php echo $this->Html->link('XML', ['action' => 'states', '_ext' => 'xml']); ?></li>
</ul>

<h3>Counties / Districts / Cities / Postal Codes</h3>
TODO
	</div>

	<div class="col-md-6 col-12">

		<h3><?php echo __('Timezones'); ?></h3>
		<div>Key information: ISO name, offset (incl dst), lat/lng, linked/alias</div>
		<?php echo $this->Html->link(__('View online'), ['plugin' => 'Data', 'controller' => 'Timezones', 'action' => 'index']); ?>
		<ul>
			<li><?php echo $this->Html->link('JSON', ['action' => 'timezones', '_ext' => 'json']); ?></li>
			<li><?php echo $this->Html->link('XML', ['action' => 'timezones', '_ext' => 'xml']); ?></li>
		</ul>

		<h3><?php echo __('Currencies'); ?></h3>
		<div>Key information: ISO codes, current value, base currency, symbol</div>
		<?php echo $this->Html->link(__('View online'), array('plugin' => 'Data', 'controller' => 'Currencies', 'action'=>'index')); ?>
		<ul>
			<li><?php echo $this->Html->link('JSON', ['action' => 'currencies', '_ext' => 'json']); ?></li>
			<li><?php echo $this->Html->link('XML', ['action' => 'currencies', '_ext' => 'xml']); ?></li>
		</ul>

		<h3><?php echo __('Languages'); ?></h3>
		<?php //echo $this->Html->link(__('View online'), array('plugin'=>'data', 'controller'=>'languages', 'action'=>'index')); ?>
		<ul>
			<li><?php echo $this->Html->link('JSON', ['action' => 'languages', '_ext' => 'json']); ?></li>
			<li><?php echo $this->Html->link('XML', ['action' => 'languages', '_ext' => 'xml']); ?></li>
		</ul>

	</div>
</div>




<br/>
Note: If you want to force downloading, append `?download=1` after the extension.
