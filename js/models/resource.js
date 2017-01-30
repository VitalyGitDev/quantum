function localResource() {
    this.name = '';
    this.dirrectory = '';
    this.repository = '';
    this.local_domain = '';
}

localResource.prototype.load = function(params) {
    for(var item in params) {
        if (this.hasOwnProperty(item)) {
            this[item] = params[item];
        }
    }

    return true;
}

localResource.prototype.serialize = function() {
    var result = {},
        _self = this;
    Object.getOwnPropertyNames(_self).forEach(function(val, i ,arr){
        result[val] = _self[val];
    });

    return result;
}

localResource.prototype.save = function(params, callback) {
    if  (this.load(params)) {
        var data = this.serialize();

        $.ajax({
            url: '/api/v1/resources/',
            data: data,
            method: 'POST',
            success: function(data){
                console.log(data);
                if ((typeof callback) == 'function') {
                    callback();
                }
            },
            error: function(e, eText){
                console.log(eText);
            }
        });
    }
}
