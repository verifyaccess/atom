<?php decorate_with('layout_2col') ?>

<?php slot('sidebar') ?>
  <div class="sidebar-lowering">

    <h2><?php echo __('Browse %1%:', array('%1%' => render_title($resource))) ?></h2>

    <?php echo get_component('term', 'treeView', array('browser' => false)) ?>

 </div>
<?php end_slot() ?>

<?php slot('title') ?>
  <div class="multiline-header">
    <?php if (isset($icon)): ?>
      <?php echo image_tag('/images/icons-large/icon-'.$icon.'.png', array('alt' => '')) ?>
    <?php endif; ?>
    <h1 aria-describedby="results-label"><?php echo __('Showing %1% results', array('%1%' => $pager->getNbResults())) ?></h1>
    <span class="sub" id="results-label"><?php echo render_title($resource) ?></span>
  </div>
<?php end_slot() ?>

<?php slot('before-content') ?>

  <section class="header-options">
    <div class="row">
      <div class="span5">
        <?php echo get_component('search', 'inlineSearch', array(
          'label' => __('Search %1%', array('%1%' => render_title($resource))),
          'route' => url_for(array('module' => 'taxonomy', 'action' => 'index', 'slug' => $resource->slug)),
          'fields' => array(
            'allLabels' => __('All labels'),
            'preferredLabel' => __('Preferred label'),
            'useForLabels' => __('"Use for" labels')))) ?>
      </div>

      <div class="pickers">
        <?php echo get_partial('default/sortPickers',
          array(
            'options' => array(
              'lastUpdated' => __('Date modified'),
              'alphabetic' => __('Name')))) ?>
      </div>
    </div>
  </section>

<?php end_slot() ?>

<?php slot('content') ?>

  <table class="table table-bordered sticky-enabled">
    <thead>
      <tr>
        <th>
          <?php echo __('%1% term', array('%1%' => render_title($resource))) ?>
        </th><th>
          <?php echo __('Scope note') ?>
        </th>
        <?php if ($addIoCountColumn): ?>
          <th><?php echo __('%1 count', array('%1' => sfConfig::get('app_ui_label_informationobject'))) ?></th>
        <?php endif; ?>
        <?php if ($addActorCountColumn): ?>
          <th><?php echo __('%1 count', array('%1' => sfConfig::get('app_ui_label_actor'))) ?></th>
        <?php endif; ?>
      </tr>
    </thead><tbody>
      <?php foreach ($pager->getResults() as $hit): ?>
        <?php $doc = $hit->getData() ?>
        <tr>
          <td>
            <?php if ($doc['isProtected']): ?>
              <?php echo link_to(render_title(get_search_i18n($doc, 'name', array('allowEmpty' => false))), array('module' => 'term', 'slug' => $doc['slug']), array('class' => 'readOnly')) ?>
            <?php else: ?>
              <?php echo link_to(render_title(get_search_i18n($doc, 'name', array('allowEmpty' => false))), array('module' => 'term', 'slug' => $doc['slug'])) ?>
            <?php endif; ?>

            <?php if (0 < $doc['numberOfDescendants']): ?>
              <span class="note2">(<?php echo $doc['numberOfDescendants'] ?>)</span>
            <?php endif; ?>

            <?php if (isset($doc['useFor']) && count($doc['useFor']) > 0): ?>
              <p>
                <?php $labels = array() ?>
                <?php echo __('Use for: ') ?>

                <?php foreach ($doc['useFor'] as $label): ?>
                  <?php $labels[] = render_value_inline(get_search_i18n($label, 'name', array('allowEmpty' => false))) ?>
                <?php endforeach; ?>

                <?php echo implode(', ', $labels) ?>
              </p>
            <?php endif; ?>

          </td><td>
            <?php if (isset($doc['scopeNotes']) && count($doc['scopeNotes']) > 0): ?>
              <ul>
                <?php foreach ($doc['scopeNotes'] as $note): ?>
                  <li><?php echo render_value_inline(get_search_i18n($note, 'content')) ?></li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>

          </td>
          <?php if ($addIoCountColumn): ?>
            <td><?php echo QubitTerm::countRelatedInformationObjects($hit->getId()) ?></td>
          <?php endif; ?>
          <?php if ($addActorCountColumn): ?>
            <td><?php echo TermNavigateRelatedComponent::getEsDocsRelatedToTermCount('QubitActor', $hit->getId()) ?></td>
          <?php endif; ?>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

<?php end_slot() ?>

<?php slot('after-content') ?>

  <?php echo get_partial('default/pager', array('pager' => $pager)) ?>

  <section class="actions">
    <ul>
      <?php if (QubitAcl::check($resource, 'createTerm')): ?>
        <li><?php echo link_to(__('Add new'), array('module' => 'term', 'action' => 'add', 'taxonomy' => url_for(array($resource, 'module' => 'taxonomy'))), array('class' => 'c-btn')) ?></li>
      <?php endif; ?>
    </ul>
  </section>

<?php end_slot() ?>
