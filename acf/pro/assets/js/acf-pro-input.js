(function($){
	
	var Field = acf.Field.extend({
		
		type: 'repeater',
		
		events: {
			'click a[data-event="add-row"]': 		'onClickAdd',
			'click a[data-event="remove-row"]': 	'onClickRemove',
			'click a[data-event="collapse-row"]': 	'onClickCollapse',
			'showField':							'onShow'
		},
		
		getControl: function(){
			return this.$('.acf-repeater:first');
		},
		
		$control: function(){
			return this.$('.acf-repeater:first');
		},
		
		$table: function(){
			return this.$control().children('table');
		},
		
		$tbody: function(){
			return this.$table().children('tbody');
		},
		
		$rows: function(){
			return this.$tbody().children();
		},
		
		$clone: function(){
			return this.$tbody().children('.acf-clone');
		},
		
		$actions: function(){
			return this.$control().children('.acf-actions');
		},
		
		$button: function(){
			return this.$actions().find('.button');
		},
		
		getValue: function(){
			return this.$rows().length - 1;
		},
		
		isFull: function(){
			var max = parseInt( this.get('max') );
			return ( max && this.val() >= max );
		},
		
		initialize: function(){
			
			// events
			this.$el.one('mouseenter', this.newEventCallback(this, 'onMouseEnter'));
			
			// disable clone
			acf.disable( this.$clone(), this.cid );
						
			// render
			this.render();
		},
		
		render: function(){
			
			// update order number
			this.$rows().each(function( i ){
				$(this).find('> .order > span').html( i+1 );
			});
			
			// empty
			if( this.val() == 0 ) {
				this.$control().addClass('-empty');
			} else {
				this.$control().removeClass('-empty');
			}
			
			// max
			if( this.isFull() ) {
				this.$button().addClass('disabled');
			} else {
				this.$button().removeClass('disabled');
			}
			
		},
		
		onClickAdd: function( e, $el ){
			
			// add above row
			if( $el.hasClass('acf-icon') ) {
				this.add({
					before: $el.closest('.acf-row')
				});
			
			// default
			} else {
				this.add();
			}
		},
		
		add: function( args ){
			
			// vars
			var $clone = this.$clone();
			
			// defaults
			args = acf.parseArgs(args, {
				before: $clone
			});
			
			// validate
			if( this.isFull() ) {
				alert( acf._e('repeater','max').replace('{max}', this.get('max')) );
				return false;
			}
			
			// add row
			var $el = acf.duplicate({
				target: $clone,
				append: function( $el, $el2 ){
					
					// remove clone class
					$el2.removeClass('acf-clone');
					
					// append
					args.before.before( $el2 );
				}
			});
			
			// enable 
			acf.enable_form( $el, this.cid );
			
			// update order
			this.render();
			
			// trigger change for validation errors
			this.getInput().trigger('change');
						
			// sync collapsed order
			//this.sync();
			
			// return
			return $el;
		},
		
/*
		sync: function(){
			
			// vars
			var name = 'collapsed_' + this.$field.data('key'),
				collapsed = [];
			
			
			// populate collapsed value
			this.$tbody.children().each(function( i ){
				
				if( $(this).hasClass('-collapsed') ) {
				
					collapsed.push( i );
					
				}
				
			});
			
			
			// update
			acf.update_user_setting( name, collapsed.join(',') );	
			
		},
*/

		onClickRemove: function( e, $el ){
			
			// vars
			var $row = $el.closest('.acf-row');
			
			// add class
			$row.addClass('-hover');
			
			// add tooltip
			var tooltip = acf.newTooltip({
				confirmRemove: true,
				target: $el,
				context: this,
				confirm: function(){
					this.remove( $row );
				},
				cancel: function(){
					$row.removeClass('-hover');
				}
			});
		},

		remove: function( $row ){
			
			// reference
			var self = this;
			
			// remove
			acf.remove({
				target: $row,
				endHeight: 0,
				complete: function(){
					
					// trigger change to allow attachment save
					self.getInput().trigger('change');
				
					// render
					self.render();
					
					// sync collapsed order
					//self.sync();
					
					// refresh field (hide/show columns)
					acf.do_action('refresh', self.$el);
				}
			});
		},
		
		onClickCollapse: function( e, $el ){
			
			// vars
			var $row = $el.closest('.acf-row');
			var isCollpased = $row.hasClass('-collapsed')
			
			// shift
			if( e.shiftKey ) {
				$row = this.$rows();
			}
			
			// is collapsed
			if( isCollpased ) {
				$row.removeClass('-collapsed');
				acf.do_action('show', $row, 'collapse');
			
			// collapse
			} else {
				$row.addClass('-collapsed');
				acf.do_action('hide', $row, 'collapse');
			}
			
			// sync
			//this.set('$field', $field).sync();
			
			// refersh field (hide/show columns)
			acf.do_action('refresh', this.$el);		
		},
		
		onMouseEnter: function( e, $el ){
			
			// bail early if max 1 row
			var max = parseInt(this.get('max'));
			if( max == 1 ) {
				return;
			}
			
			// reference
			var self = this;
			
			// add sortable
			this.$tbody().sortable({
				items: '> tr',
				handle: '> td.order',
				forceHelperSize: true,
				forcePlaceholderSize: true,
				scroll: true,
	   			stop: function(event, ui) {
					self.render();
	   			},
	   			update: function(event, ui) {
					self.getInput().trigger('change');
		   		}
			});
		},
		
		onShow: function( e, context ){
			
			// get sub fields
			var fields = acf.findFields({
				is: ':visible',
				parent: this.$el,
			});
			
			// trigger action
			// - ignore context, no need to pass through 'conditional_logic'
			// - this is just for fields like google_map to render itself
			fields.each(function(){
				acf.do_action('show_field', $(this));
			});
		}
	});
	
	acf.registerFieldType( Field );
	
	// register existing conditions
	acf.registerConditionForFieldType('hasValue', 'repeater');
	acf.registerConditionForFieldType('hasNoValue', 'repeater');
	acf.registerConditionForFieldType('lessThan', 'repeater');
	acf.registerConditionForFieldType('greaterThan', 'repeater');
		
})(jQuery);

(function($){
	
	var Field = acf.Field.extend({
		
		type: 'flexible_content',
		
		events: {
			'click [data-name="add-layout"]': 		'onClickAdd',
			'click [data-name="remove-layout"]': 	'onClickRemove',
			'click [data-name="collapse-layout"]': 	'onClickCollapse',
			'showField':							'onShow'
		},
		
		control: '.acf-flexible-content:first',
		
		getLayoutsWrap: function(){
			return this.find('> .values');
		},
		
		getLayouts: function(){
			return this.find('> .values > .layout');
		},
		
		getClonesWrap: function(){
			return this.find('> .clones');
		},
		
		getClones: function(){
			return this.find('> .clones > .layout');
		},
		
		getClone: function( name ){
			return this.find('> .clones > .layout[data-layout="' + name + '"]');
		},
		
		getButton: function(){
			return this.find('> .acf-actions .button');
		},
		
		getPopupHTML: function(){
			
			// vars
			var html = this.find('> .tmpl-popup').html();
			var $html = $(html);
			
			// count layouts
			var $layouts = this.getLayouts();
			var countLayouts = function( name ){
				return $layouts.filter(function(){
					return $(this).data('layout') === name;
				}).length;
			};
						
			// modify popup
			$html.find('[data-layout]').each(function(){
				
				// vars
				var $a = $(this);
				var min = $a.data('min') || 0;
				var max = $a.data('max') || 0;
				var name = $a.data('layout') || '';
				var count = countLayouts( name );
				
				// max
				if( max && count >= max) {
					$a.addClass('disabled');
					return;
				}
				
				// min
				if( min && count < min ) {
					
					// vars
					var required = min - count;
					var title = this.__('required');
					var identifier = (required = 1) ? this.__('layout') : this.__('layouts');
										
					// translate
					title = title.replace('{required}', required);
					title = title.replace('{label} ', ''); // 5.5.0
					title = title.replace('{identifier}', identifier);
					title = title.replace('{min}', min);
					
					// badge
					$a.append('<span class="badge" title="' + title + '">' + required + '</span>');
				}
			});
			
			// update
			html = $html.outerHTML();
			
			// return
			return html;
		},
		
		getValue: function(){
			return this.getLayouts().length;
		},
		
		isFull: function(){
			var max = parseInt( this.get('max') );
			return ( max && this.val() >= max );
		},
		
		initialize: function(){
			
			// events
			this.$el.one('mouseenter', this.newEventCallback(this, 'onMouseEnter'));
			
			// disable clone
			acf.disable( this.getClonesWrap(), this.cid );
						
			// render
			this.render();
		},
		
		render: function(){
			
			// update order number
			this.getLayouts().each(function( i ){
				$(this).find('.acf-fc-layout-order:first').html( i+1 );
			});
			
			// empty
			if( this.val() == 0 ) {
				this.getControl().addClass('-empty');
			} else {
				this.getControl().removeClass('-empty');
			}
			
			// max
			if( this.isFull() ) {
				this.getButton().addClass('disabled');
			} else {
				this.getButton().removeClass('disabled');
			}
		},
		
		onShow: function( e, context ){
			
			// get sub fields
			var fields = acf.findFields({
				is: ':visible',
				parent: this.$el,
			});
			
			// trigger action
			// - ignore context, no need to pass through 'conditional_logic'
			// - this is just for fields like google_map to render itself
			fields.each(function(){
				acf.do_action('show_field', $(this));
			});
		},
		
		onMouseEnter: function( e, $el ){
			
			// bail early if max 1 row
			var max = parseInt(this.get('max'));
			if( max == 1 ) {
				return;
			}
			
			// reference
			var self = this;
			
			// add sortable
			this.getLayoutsWrap().sortable({
				items: '> .layout',
				handle: '> .acf-fc-layout-handle',
				forceHelperSize: true,
				forcePlaceholderSize: true,
				scroll: true,
	   			stop: function(event, ui) {
					self.render();
	   			},
	   			update: function(event, ui) {
		   			self.getInput().trigger('change');
		   		}
			});
		},
		
		onClickAdd: function( e, $el ){
			
			// bail early if is full
			if( this.isFull() ) {
				return;
			}
			
			// within layout
			var $layout = null;
			if( $el.hasClass('acf-icon') ) {
				$layout = $el.closest('.layout');
				$layout.addClass('-hover');
			}
			
			// new popup
			var popup = new Popup({
				target: $el,
				targetConfirm: false,
				text: this.getPopupHTML(),
				context: this,
				confirm: function( e, $el ){
					
					// check disabled
					if( $el.hasClass('disabled') ) {
						return;
					}
					
					// add
					this.add({
						layout: $el.data('layout'),
						before: $layout
					});
				},
				cancel: function(){
					if( $layout ) {
						$layout.removeClass('-hover');
					}
					
				}
			});
			
			// add extra event
			popup.on('click [data-layout]', 'onConfirm');
		},
		
		add: function( args ){
			
			// defaults
			args = acf.parseArgs(args, {
				layout: '',
				before: false
			});
			
			// append
			args.append = this.getLayoutsWrap();
			
			// validate
			if( this.isFull() ) {
				return false;
			}
			
			// add row
			var $el = acf.duplicate({
				target: this.getClone( args.layout ),
				append: function( $el, $el2 ){
					
					if( args.before ) {
						args.before.before( $el2 );
					} else {
						args.append.append( $el2 );
					}
				}
			});
			
			// enable 
			acf.enable_form( $el, this.cid );
			
			// update order
			this.render();
			
			// trigger change for validation errors
			this.getInput().trigger('change');
						
			// sync collapsed order
			//this.sync();
			
			// return
			return $el;
		},
		
		onClickRemove: function( e, $el ){
			
			// vars
			var $layout = $el.closest('.layout');
			
			// add class
			$layout.addClass('-hover');
			
			// add tooltip
			var tooltip = acf.newTooltip({
				confirmRemove: true,
				target: $el,
				context: this,
				confirm: function(){
					this.removeLayout( $layout );
				},
				cancel: function(){
					$layout.removeClass('-hover');
				}
			});
		},
		
		removeLayout: function( $layout ){
			
			// reference
			var self = this;
			
			// vars
			var endHeight = this.getValue() == 1 ? 60: 0;
			
			// remove
			acf.remove({
				target: $layout,
				endHeight: endHeight,
				complete: function(){
					
					// trigger change to allow attachment save
					self.getInput().trigger('change');
				
					// render
					self.render();
					
					// sync collapsed order
					//self.sync();
				}
			});
		},
		
		onClickCollapse: function( e, $el ){
			
			// vars
			var $layout = $el.closest('.layout');
			
			// render
			this.renderLayout( $layout );
			
			// is collapsed
			if( $layout.hasClass('-collapsed') ) {
				$layout.removeClass('-collapsed');
				acf.do_action('show', $layout, 'collapse');
			
			// collapse
			} else {
				$layout.addClass('-collapsed');
				acf.do_action('hide', $layout, 'collapse');
			}
			
			// sync
			//this.sync();
		},
		
		renderLayout: function( $layout ){
			
			// vars
			var $input = $layout.children('input');
			var prefix = $input.attr('name').replace('[acf_fc_layout]', '');
			
			// ajax data
			var ajaxData = {
				action: 	'acf/fields/flexible_content/layout_title',
				field_key: 	this.get('key'),
				i: 			$layout.index(),
				layout:		$layout.data('layout'),
				value:		acf.serialize( $layout, prefix )
			};
			
			// ajax
			$.ajax({
		    	url: acf.get('ajaxurl'),
		    	data: acf.prepareForAjax(ajaxData),
				dataType: 'html',
				type: 'post',
				success: function( html ){
					if( html ) {
						$layout.children('.acf-fc-layout-handle').html( html );
					}
				}
			});
		},
						
	});
	
	acf.registerFieldType( Field );
	
	
	
	/**
	*  Popup
	*
	*  description
	*
	*  @date	7/4/18
	*  @since	5.6.9
	*
	*  @param	type $var Description. Default.
	*  @return	type Description.
	*/
	
	var Popup = acf.models.TooltipConfirm.extend({
		
		events: {
			'click [data-layout]': 			'onConfirm',
			'click [data-event="cancel"]':	'onCancel',
		},
		
		render: function(){
			
			// set HTML
			this.html( this.get('text') );
			
			// add class
			this.$el.addClass('acf-fc-popup');
		}		
	});
	
	
	/**
	*  conditions
	*
	*  description
	*
	*  @date	9/4/18
	*  @since	5.6.9
	*
	*  @param	type $var Description. Default.
	*  @return	type Description.
	*/
	
	// register existing conditions
	acf.registerConditionForFieldType('hasValue', 'flexible_content');
	acf.registerConditionForFieldType('hasNoValue', 'flexible_content');
	acf.registerConditionForFieldType('lessThan', 'flexible_content');
	acf.registerConditionForFieldType('greaterThan', 'flexible_content');
	
})(jQuery);

(function($){
	
	var Field = acf.Field.extend({
		
		type: 'gallery',
		
		events: {
			'click .acf-gallery-add':			'onClickAdd',
			'click .acf-gallery-edit':			'onClickEdit',
			'click .acf-gallery-remove':		'onClickRemove',
			'click .acf-gallery-attachment': 	'onClickSelect',
			'click .acf-gallery-close': 		'onClickClose',
			'change .acf-gallery-sort': 		'onChangeSort',
			
			'click .acf-gallery-update': 		'onUpdate',
		},
		
		actions: {
			'validation_begin': 	'onValidationBegin',
			'validation_failure': 	'onValidationFailure'
		},
		
		onValidationBegin: function(){
			acf.disable( this.$sideData(), this.cid );
		},
		
		onValidationFailure: function(){
			acf.enable( this.$sideData(), this.cid );
		},
		
		getControl: function(){
			return this.$('.acf-gallery');
		},
		
		$control: function(){
			return this.$('.acf-gallery');
		},
		
		$collection: function(){
			return this.$('.acf-gallery-attachments');
		},
		
		$attachments: function(){
			return this.$('.acf-gallery-attachment');
		},
		
		$attachment: function( id ){
			return this.$('.acf-gallery-attachment[data-id="' + id + '"]');
		},
		
		$active: function(){
			return this.$('.acf-gallery-attachment.active');
		},
		
		$main: function(){
			return this.$('.acf-gallery-main');
		},
		
		$side: function(){
			return this.$('.acf-gallery-side');
		},
		
		$sideData: function(){
			return this.$('.acf-gallery-side-data');
		},
		
		isFull: function(){
			var max = parseInt( this.get('max') );
			var count = this.$attachments().length;
			return ( max && count >= max );
		},
		
		getValue: function(){
			
			// vars
			var val = [];
			
			// loop
			this.$attachments().each(function(){
				val.push( $(this).data('id') );
			});
			
			// return
			return val;
		},
		
		initialize: function(){
			
			// sortable
			this.$collection().sortable({
				items: '.acf-gallery-attachment',
				forceHelperSize: true,
				forcePlaceholderSize: true,
				scroll: true,
				start: function (event, ui) {
					ui.placeholder.html( ui.item.html() );
					ui.placeholder.removeAttr('style');
	   			}
			});
			
			// resizable
			this.$control().resizable({
				handles: 's',
				minHeight: 200,
				stop: function(event, ui){
					acf.update_user_setting('gallery_height', ui.size.height);
				}
			});
			
			// manually apply these events to avoid scope / context issues
			this.on('resize', this.proxy(this.onResize), $(window));
			this.on('change .acf-gallery-side', this.proxy(this.onUpdate));
			
			// render
			this.render();
		},
		
		render: function(){
			
			// vars
			var $sort = this.$('.acf-gallery-sort');
			var $add = this.$('.acf-gallery-add');
			var count = this.$attachments().length;
			
			// disable add
			if( this.isFull() ) {
				$add.addClass('disabled');
			} else {
				$add.removeClass('disabled');
			}
			
			// disable select
			if( !count ) {
				$sort.addClass('disabled');
			} else {
				$sort.removeClass('disabled');
			}
			
			// resize
			this.resize();
		},
		
		resize: function(){
			
			// vars
			var width = this.$control().width();
			var target = 150;
			var columns = Math.round( width / target );
						
			// max columns = 8
			columns = Math.min(columns, 8);
			
			// update data
			this.$control().attr('data-columns', columns);
		},
		
		onResize: function(){
			this.resize();
		},
		
		openSidebar: function(){
			
			// add class
			this.$control().addClass('-open');
			
			// hide bulk actions
			// should be done with CSS
			//this.$main().find('.acf-gallery-sort').hide();
			
			// vars
			var width = this.$control().width() / 3;
			width = parseInt( width );
			width = Math.max( width, 350 );
			
			// animate
			this.$('.acf-gallery-side-inner').css({ 'width' : width-1 });
			this.$side().animate({ 'width' : width-1 }, 250);
			this.$main().animate({ 'right' : width }, 250);
		},
		
		closeSidebar: function(){
			
			// remove class
			this.$control().removeClass('-open');
			
			// clear selection
			this.$active().removeClass('active');
			
			// disable sidebar
			acf.disable( this.$side() );
			
			// animate
			var $sideData = this.$('.acf-gallery-side-data');
			this.$main().animate({ right: 0 }, 250);
			this.$side().animate({ width: 0 }, 250, function(){
				$sideData.html('');
			});
		},
		
		onClickAdd: function( e, $el ){
			
			// validate
			if( this.isFull() ) {
				this.showNotice({
					text: acf._e('gallery', 'max'),
					type: 'warning'
				});
				return;
			}
			
			// new frame
			var frame = acf.newMediaPopup({
				mode:			'select',
				title:			acf._e('gallery', 'select'),
				field:			this.get('key'),
				multiple:		'add',
				library:		this.get('library'),
				allowedTypes:	this.get('mime_types'),
				selected:		this.val(),
				select:			$.proxy(function( attachment, i ) {
					this.appendAttachment( attachment, i );
				}, this)
			});
		},
		
		appendAttachment: function( attachment, i ){
			
			// vars
			attachment = this.validateAttachment( attachment );
			
			// bail early if is full
			if( this.isFull() ) {
				return;
			}
			
			// bail early if already exists
			if( this.$attachment( attachment.id ).length ) {
				return;
			}
			
			// html
			var html = [
			'<div class="acf-gallery-attachment" data-id="' + attachment.id + '">',
				'<input type="hidden" value="' + attachment.id + '" name="' + this.getInputName() + '[]">',
				'<div class="margin" title="">',
					'<div class="thumbnail">',
						'<img src="" alt="">',
					'</div>',
					'<div class="filename"></div>',
				'</div>',
				'<div class="actions">',
					'<a href="#" class="acf-icon -cancel dark acf-gallery-remove" data-id="' + attachment.id + '"></a>',
				'</div>',
			'</div>'].join('');
			var $html = $(html);
			
			// append
			this.$collection().append( $html );
			
			// move to beginning
			if( this.get('insert') === 'prepend' ) {
				var $before = this.$attachments().eq( i );
				if( $before.length ) {
					$before.before( $html );
				}
			}
			
			// render attachment
			this.renderAttachment( attachment );
			
			// render
			this.render();
			
			// trigger change
			this.getInput().trigger('change');
		},
		
		validateAttachment: function( attachment ){
			
			// defaults
			attachment = acf.parseArgs(attachment, {
				id: '',
				url: '',
				alt: '',
				title: '',
				filename: '',
				type: 'image'
			});
			
			// WP attachment
			if( attachment.attributes ) {
				attachment = attachment.attributes;
				
				// preview size
				var url = acf.isget(attachment, 'sizes', 'medium', 'url');
				if( url !== null ) {
					attachment.url = url;
				}
			}
			
			// return
			return attachment;
		},
		
		renderAttachment: function( attachment ){
			
			// vars
			attachment = this.validateAttachment( attachment );
			
			// vars
			var $el = this.$attachment( attachment.id );
			
			// image
			if( attachment.type == 'image' ) {
				
				// remove filename	
				$el.find('.filename').remove();
			
			// other (video)	
			} else {	
				
				// attempt to find attachment thumbnail
				attachment.url = acf.isget(attachment, 'thumb', 'src');
				
				// update filename
				$el.find('.filename').text( attachment.filename );
			}
			
			// default icon
			if( !attachment.url ) {
				attachment.url = acf.get('mimeTypeIcon');
				$el.addClass('-icon');
			}
			
			// update els
		 	$el.find('img').attr({
			 	src:	attachment.url,
			 	alt:	attachment.alt,
			 	title:	attachment.title
			});
		 	
			// update val
		 	acf.val( $el.find('input'), attachment.id );
		},
		
		editAttachment: function( id ){
			
			// new frame
			var frame = acf.newMediaPopup({
				mode:		'edit',
				title:		acf._e('image', 'edit'),
				button:		acf._e('image', 'update'),
				attachment:	id,
				field:		this.get('key'),
				select:		$.proxy(function( attachment, i ) {
					this.renderAttachment( attachment );
					// todo - render sidebar
				}, this)
			});
		},
		
		onClickEdit: function( e, $el ){
			var id = $el.data('id');
			if( id ) {
				this.editAttachment( id );
			}
		},
		
		removeAttachment: function( id ){
			
			// close sidebar (if open)
			this.closeSidebar();
			
			// remove attachment
			this.$attachment( id ).remove();
			
			// render
			this.render();
			
			// trigger change
			this.getInput().trigger('change');
		},
		
		onClickRemove: function( e, $el ){
			
			// prevent event from triggering click on attachment
			e.preventDefault();
			e.stopPropagation();
			
			//remove
			var id = $el.data('id');
			if( id ) {
				this.removeAttachment( id );
			}
		},
		
		selectAttachment: function( id ){
			
			// vars
			var $el = this.$attachment( id );
			
			// bail early if already active
			if( $el.hasClass('active') ) {
				return;
			}
			
			// step 1
			var step1 = this.proxy(function(){
				
				// save any changes in sidebar
				this.$side().find(':focus').trigger('blur');
				
				// clear selection
				this.$active().removeClass('active');
				
				// add selection
				$el.addClass('active');
				
				// open sidebar
				this.openSidebar();
				
				// call step 2
				step2();
			});
			
			// step 2
			var step2 = this.proxy(function(){
				
				// ajax
				var ajaxData = {
					action: 'acf/fields/gallery/get_attachment',
					field_key: this.get('key'),
					id: id
				};
				
				// abort prev ajax call
				if( this.has('xhr') ) {
					this.get('xhr').abort();
				}
				
				// loading
				acf.showLoading( this.$sideData() );
				
				// get HTML
				var xhr = $.ajax({
					url: acf.get('ajaxurl'),
					data: acf.prepareForAjax(ajaxData),
					type: 'post',
					dataType: 'html',
					cache: false,
					success: step3
				});
				
				// update
				this.set('xhr', xhr);
			});
			
			// step 3
			var step3 = this.proxy(function( html ){
				
				// bail early if no html
				if( !html ) {
					return;
				}
				
				// vars
				var $side = this.$sideData();
				
				// render
				$side.html( html );
				
				// remove acf form data
				$side.find('.compat-field-acf-form-data').remove();
				
				// merge tables
				$side.find('> table.form-table > tbody').append( $side.find('> .compat-attachment-fields > tbody > tr') );	
								
				// setup fields
				acf.do_action('append', $side);
			});
			
			// run step 1
			step1();
		},
		
		onClickSelect: function( e, $el ){
			var id = $el.data('id');
			if( id ) {
				this.selectAttachment( id );
			}
		},
		
		onClickClose: function( e, $el ){
			this.closeSidebar();
		},
		
		onChangeSort: function( e, $el ){
			
			// vars
			var val = $el.val();
			
			// validate
			if( !val ) {
				return;
			}
			
			// find ids
			var ids = [];
			this.$attachments().each(function(){
				ids.push( $(this).data('id') );
			});
			
			// step 1
			var step1 = this.proxy(function(){
				
				// vars
				var ajaxData = {
					action: 'acf/fields/gallery/get_sort_order',
					field_key: this.get('key'),
					ids: ids,
					sort: val
				};
				
				
				// get results
			    var xhr = $.ajax({
			    	url:		acf.get('ajaxurl'),
					dataType:	'json',
					type:		'post',
					cache:		false,
					data:		acf.prepareForAjax(ajaxData),
					success:	step2
				});
			});
			
			// step 2
			var step2 = this.proxy(function( json ){
				
				// validate
				if( !acf.isAjaxSuccess(json) ) {
					return;
				}
				
				// reverse order
				json.data.reverse();
				
				// loop
				json.data.map(function(id){
					this.$collection().prepend( this.$attachment(id) );
				}, this);
			});
			
			// call step 1
			step1();
		},
		
		onUpdate: function( e, $el ){
			console.log('onUpdate');
			// vars
			var $submit = this.$('.acf-gallery-update');
			
			// validate
			if( $submit.hasClass('disabled') ) {
				return;
			}
			
			// serialize data
			var ajaxData = acf.serialize( this.$sideData() );
			
			// loading
			$submit.addClass('disabled');
			$submit.before('<i class="acf-loading"></i>');
			
			// append AJAX action		
			ajaxData.action = 'acf/fields/gallery/update_attachment';
			
			// ajax
			$.ajax({
				url: acf.get('ajaxurl'),
				data: acf.prepareForAjax(ajaxData),
				type: 'post',
				dataType: 'json',
				complete: function(){
					$submit.removeClass('disabled');
					$submit.prev('.acf-loading').remove();
				}
			});
		}
	});
	
	acf.registerFieldType( Field );
	
	// register existing conditions
	acf.registerConditionForFieldType('hasValue', 'gallery');
	acf.registerConditionForFieldType('hasNoValue', 'gallery');
	acf.registerConditionForFieldType('lessThan', 'gallery');
	acf.registerConditionForFieldType('greaterThan', 'gallery');
	
})(jQuery);

// @codekit-prepend "../js/acf-field-repeater.js";
// @codekit-prepend "../js/acf-field-flexible-content.js";
// @codekit-prepend "../js/acf-field-gallery.js";

