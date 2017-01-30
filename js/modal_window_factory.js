function modal_window_factory() {
	this.modalHTML = '<div class="window_background" style="display: none;">'
					+'<div class="cat_window userview" style="top: 68.3px; left: 255.6px; width: 766.8px; height: 546.4px;">'
						+'<div id="modal_close" class="btn_close"></div>'
						+'<div class="container"></div>'
						+'<br><div class="buttons row">'
							+'<div class="button three columns offset-by-three" id="modal_btn_ok">Ok</div>'
							+'<div class="button three columns offset-by-one" id="modal_btn_cancel">Cancel</div>'
						+'</div>'
					+'</div>'
				+'</div>';

	this.categoryField = '<input type=hidden name="category" value="{category}">';

	this.resourceCreation = '<div class="container">'
						+'<div class="row"><div class="ten columns offset-by-one"><h4>Создание нового ресурса</h4></div></div>'
						+'<div class="row">'
							+'<div class="label four columns" style="line-height: 36px;">Название ресурса:</div><div class="eight columns "><input type=text name="name" style="width: 100%;"></div>'
						+'</div>'
						+'<div class="row">'
							+'<div class="label four columns" style="line-height: 36px;">Репозиторий:</div><div class="eight columns "><input type=text name="repository" style="width: 100%;"></div>'
						+'</div>'
						+'<div class="row">'
							+'<div class="label four columns" style="line-height: 36px;">Папка:</div><div class="eight columns "><input type=text name="dirrectory" style="width: 100%;"></div>'
						+'</div>'
						+'<div class="row">'
							+'<div class="label four columns" style="line-height: 36px;">Локальный домен:</div><div class="eight columns "><input type=text name="local_domain" style="width: 100%;"></div>'
						+'</div>'
					+'</div>';
}

modal_window_factory.prototype.get = function(name, category){
        var innerHTML = '',
			container = $('.cat_window .container');
		if (this.hasOwnProperty(name)) {
			innerHTML = this[name] + this['categoryField'].replace('{category}', category);
		}
		container.html('');
		container.append(innerHTML);
        return true;
}

modal_window_factory.prototype.createModal = function(container, model) {
	var w_width = (container.width() / 5)*3,
		w_height = (container.height() / 10)*6;
		x = (container.width() - w_width)/2,
		y = (container.height() - w_height)/5,

	container.append(this.modalHTML);

	container.find('.cat_window').css({
		'top': y,
		'left': x,
		'width': w_width,
		'height': w_height
	});
	//console.log(model.serialize());
	this.setModalTriggers(container, 'modal_close', 'modal_btn_cancel', 'modal_btn_ok', model);
}

modal_window_factory.prototype.setModalTriggers = function(container, closeId, cancelId, okId, model) {
	var _self = this;

	container.find('#' + closeId).on('click', function(){
	    container.find('.window_background').hide();
	});

	container.find('#' + cancelId).on('click', function(){
	    $('.window_background').hide();
	});

	container.find('#' + okId).on('click', function(){
		console.log("Save btn");
		model.save(_self.getModalInputValues(), function(){$('.window_background').hide();});
	});
}

modal_window_factory.prototype.getModalInputValues = function() {
	var params = {};
	$('.window_background .container input').each(function(){
		params[$(this).attr('name')] = $(this).val();
	});

	return params;
}
