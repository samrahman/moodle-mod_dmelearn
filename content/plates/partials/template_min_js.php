<?php
// Minified Version of template_js.php
// Setup Variables
$coursepath = $page_data['data']['cert_data']['course_path'];
?><script>
!function(a,b,c){var d=a.routes;d.base="<?=$constants['base_url']?>",d.course.path=d.base+"courses/<?=$coursepath?>/",d.course.img=d.base+"images/",d.course.resources=d.course.path+"resources/",d.course.images=d.course.resources+"images/"}(window);
$(function(){$.support.cors=true;var a="elmo_ajax_ws.php?request=";$.ajaxSetup({global:!0,beforeSend:function(b,c){var d=c.url;if(d.indexOf("/form_interactive/loadData/")>-1){var e=d.split("form_interactive/loadData/"),f=e[1].split("?")[0];c.url=a+"form_interactive_load/"+f+"/<?=$coursepath?>"}else if(d.indexOf("/form_interactive/checkData/")>-1){var e=d.split("form_interactive/checkData/"),f=e[1].split("?")[0];c.url=a+"form_interactive_set/"+f+"/<?=$coursepath?>"}else{var e=d.split("/client_api");1===$(e).length&&(e=null),null!==e?c.url=a+e[1]:0===d.indexOf("<?=$constants['elmo_env']?>")&&(c.url=a+d)}}}),"undefined"!=typeof $.fn.elmo_multipleChoice&&$(".question").elmo_multipleChoice({imagePath:window.routes.img,courseImages:window.routes.course.images});var b=$(".reset_button"),d=function(){b.on("click",function(){b.unbind("click");$.ajax({type:"POST",url:"elmo_ajax_ws_reset.php",data:{course_path:"<?=$coursepath?>",user_id:"<?=$page_data['data']['cert_data']['user_id']?>"},success:function(a,c){1==a?(b.parents(".modal").modal("hide"),window.location.href="<?=$content_url?>",d()):(b.parents(".modal").modal("hide"),alert("Sorry something went wrong. This course assessment could not be reset."),d())}})})};d()});
</script>