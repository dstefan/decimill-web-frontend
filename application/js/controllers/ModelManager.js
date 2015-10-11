ModelManager = {
'compile_model': function(options) {
var o = {};o.url = '/broker/call/modelmanager/compile_model/?ajax&route';
o.type = 'POST';
o.async = true;
if (options !== undefined && options.exception !== undefined) {o.exception = options.exception;}
if (options !== undefined && options.beforeSend !== undefined) {o.beforeSend = options.beforeSend;}
if (options !== undefined && options.success !== undefined) {o.success = options.success;}
if (options !== undefined && options.post !== undefined) {o.data = options.post;}
return ajax(o);
},
'update_model_title': function(options) {
var o = {};o.url = '/broker/call/modelmanager/update_model_title/?ajax&route';
o.type = 'POST';
o.async = true;
if (options !== undefined && options.exception !== undefined) {o.exception = options.exception;}
if (options !== undefined && options.beforeSend !== undefined) {o.beforeSend = options.beforeSend;}
if (options !== undefined && options.success !== undefined) {o.success = options.success;}
if (options !== undefined && options.post !== undefined) {o.data = options.post;}
return ajax(o);
}
}