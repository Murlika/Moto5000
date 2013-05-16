jQuery(function ($) {

jQuery(document).ready(function(e) {

 //Checking IE version
 //if ( $.browser.msie && $.browser.version <= 6 ) {
 //           window.document.location = '/badbrowser.php';
 //}

  jQuery('#slideshow').slidesjs({
        width: 640,
        height: 430,
         navigation: false,
         play: {
          auto: true,
          interval: 4000,
          swap: true,
          pauseOnHover: true,
          restartDelay: 2500
        }
      });

// кривоватый аякс тут, надо бы поменять
  var options = {
    // элемент, который будет обновлен по ответу сервера
    target: "#err_output",
    url: "ajax_response.php",
    type:'post',
    beforeSubmit: showRequest, // функция, вызываемая перед передачей
    success: showResponse, // функция, вызываемая при получении ответа
    timeout: 3000 // тайм-аут
  };
 
 jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
    phone_number = phone_number.replace(/\s+/g, "");
	return this.optional(element) || phone_number.length > 9 &&
		phone_number.match(/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/);
}, "Please specify a valid phone number");



    jQuery('.form-vertical').submit(function(e) {
   $idD=$(this).parent('div').parent('div');

   $idDS=$(this).attr("id");

   console.log($idDS);

   //проверка формы
   $dd=$('#'+$idDS).validate().form();

    //console.log($dd);
   if ($dd) {
    
    $tk=jQuery(this).ajaxSubmit(options);
    jQuery('#'+$idDS).resetForm();
         $idD.modal('hide');
   }
    // !!! Важно !!!
    // всегда возвращаем false, чтобы предупредить стандартные
    // действия браузера (переход на страницу form.php)
    return false;
  });

});

// вызов перед передачей данных
function showRequest(formData, jqForm, options) {
    // formData - массив; здесь используется $.param чтобы преобразовать его в строку для вывода в alert(),
    // (только в демонстрационных целях), но в самом плагине jQuery Form это совершается автоматически.
    var queryString = $.param(formData);
    // jqForm это jQuery объект, содержащий элементы формы.
    // Для доступа к элементам формы используйте
    // var formElement = jqForm[0];
   // alert('Вот что мы передаем: \n\n' + queryString);
    // здесь можно вернуть false чтобы запретить отправку формы;
    // любое отличное от fals значение разрешит отправку формы.
    return true;
}

// вызов после получения ответа
function showResponse(responseText, statusText)  {
    // для обычного html ответа, первый аргумент - свойство responseText
    // объекта XMLHttpRequest

    // если применяется метод ajaxSubmit (или ajaxForm) с использованием опции dataType
    // установленной в 'xml', первый аргумент - свойство responseXML
    // объекта XMLHttpRequest

    // если применяется метод ajaxSubmit (или ajaxForm) с использованием опции dataType
    // установленной в 'json', первый аргумент - объек json, возвращенный сервером.

   // alert('Статус ответа сервера: ' + statusText + '\n\nТекст ответа сервера: \n' + responseText +
   //     '\n\nЦелевой элемент div обновиться этим текстом.');
  //  $('#gallery_click').click();
  // $('#contact_name').val('Ваше имя');
   //$('#contact_tel').val('Номер телефона');
  // $('#contact_comment').val('Комментарий');
    jQuery('#ModalAnsw').modal();

}


});