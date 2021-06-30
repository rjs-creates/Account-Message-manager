function ajaxRequest(urlin,typein,datain,dataTypein,successFunction,errorFunction)
{
    let ajaxOptions = {};

        ajaxOptions['url'] = urlin;
        ajaxOptions['type'] = typein;
        ajaxOptions['data'] = datain;
        ajaxOptions['dataType'] = dataTypein;
        ajaxOptions['success'] = successFunction;
        ajaxOptions['error'] = errorFunction;

        $.ajax(ajaxOptions);
}