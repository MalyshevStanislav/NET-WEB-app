
<?
//подключаем пролог ядра bitrix
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
//устанавливаем заголовок страницы
$APPLICATION->SetTitle("AJAX");

   CJSCore::Init(array('ajax'));
   $sidAjax = 'testAjax';
if(isset($_REQUEST['ajax_form']) && $_REQUEST['ajax_form'] == $sidAjax){
   $GLOBALS['APPLICATION']->RestartBuffer();
   echo CUtil::PhpToJSObject(array(
            'RESULT' => 'HELLO',
            'ERROR' => ''
   ));
   die();
}

?>
/*задаем пустой блок для отображения данных и блок для процесса загрузки
<div class="group">
   <div id="block"></div >
   <div id="process">wait ... </div >
</div>

<script>
   window.BXDEBUG = true; /*включаем режим отладки для библиотеки BX */
function DEMOLoad(){
   BX.hide(BX("block")); /*скрываем блок*/ */
   BX.show(BX("process")); /*показываем элемент загрузки*/
   /*выполняется ajax-запрос к странице с формой*/
   BX.ajax.loadJSON(
      '<?=$APPLICATION->GetCurPage()?>?ajax_form=<?=$sidAjax?>',
      DEMOResponse /*вызывается функция вывода информации в консоль*/
   );
}
function DEMOResponse (data){
   BX.debug('AJAX-DEMOResponse ', data); /*выводим данные с типом дата*/ */
   BX("block").innerHTML = data.RESULT; /*заполняем блок данными из запроса*/ */
   BX.show(BX("block")); /*показываем блок с данными*/ */
   BX.hide(BX("process"));/*скрываем элемент загрузки*/ */

   BX.onCustomEvent( /*генерация пользовательского события*/ */
      BX(BX("block")),/*получаем ссылку на элемент блока*/ */
      'DEMOUpdate' /*индентификатор события для элемента с типом block*/ */
   );
}

BX.ready(function(){
   /*
   BX.addCustomEvent(BX("block"), 'DEMOUpdate', function(){
      window.location.href = window.location.href;
   });
   */
   BX.hide(BX("block")); /*скрываем элемент "block"*/ */
   BX.hide(BX("process")); /*скрываем элемент с загрузкой*/ */
   /*делегируем обработку события на родительский элемент в document.body*/
    BX.bindDelegate(  */ /*вызываем функцию делегирования события*/ */
      document.body, 'click', {className: 'css_ajax' }, /*в родительском документе по клику на элемент с классом css_ajax будет запущена функция*/ */
      function(e){ /*объявляем функцию*/ */
         if(!e)
            e = window.event; /*обеспечиваем совместимость с браузерами*/ */
         
         DEMOLoad(); /*вызываем функцию DEMOLoad()*/ */
         return BX.PreventDefault(e); /*предотвращаем выполнения действия по умолчанию*/ */
      }
   );
   
});

</script>
<div class="css_ajax">click Me</div> /*создаем элемент, по клику на который будет вызываться функция DEMOLoad*/ */
<?
//подключаем эпилог ядра bitrix
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
