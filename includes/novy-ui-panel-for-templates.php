<div class="novy-panel">
<div class="novy-builder-panel">
	<div class="fl-builder-panel-actions">
		<i class="fl-builder-panel-close fa fa-times"></i>
	</div>
	</div>
	<div class="novy-fl-builder-panel-content-wrap fl-nanoscroller">
		<div class="fl-builder-panel-content fl-nanoscroller-content">
			<div class="fl-builder-blocks">
				<div class="novy-search-bar">
					<input type="text" class="novy-search-input" value="" placeholder="Search..." />
				</div>
			</div>
			<div class="fl-builder-blocks">

				<?php if ( count( $novy_row_templates['categorized'] ) > 0 ) : ?>
					<?php foreach ( $novy_row_templates['categorized'] as $key => $cat ) : ?>
						<div class="fl-builder-blocks-section">
							<span class="fl-builder-blocks-section-title">
								<?php echo $cat['name'];?>
								<i class="fa fa-chevron-down"></i>
							</span>
							<div class="fl-builder-blocks-section-content fl-builder-row-templates">
								<?php foreach ( $cat['templates'] as $template ) : ?>
									<span class="fl-builder-block fl-builder-block-template fl-builder-block-row-template" data-id="<?php echo $template['id']; ?>" data-type="<?php echo $template['type']; ?>">
										<img class="fl-builder-block-template-image" src="<?php echo $template['image']; ?>" />
										<span class="fl-builder-block-title"><?php echo $template['name']; ?></span>
									</span>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>