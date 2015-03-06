<?

title_of_task('Task 3','Javascript. Print image on screen within border of 300x300. Add the ability to approximate and to alienate this image inside border with a help of +key and -key');

?>
<div class="before-image-task3">
<div class="image-task3">
<div>
  <img src="/images/task3-image.jpg" id="id_img">
</div>
</div>
</div>

<script>
  (function(){
    var d, c, m;
    c=20;//��� � ����������� ������
    m=300;//������������ ������
    d=document;



    d.onkeyup=function(ev){
      ev=ev?ev:event;
      var k=ev.keyCode;
//�� �������� ����, �� ��������, � ���� �� ��������
      if(k==107||k==187||k==61){zooms('+');};
      if(k==109||k==189||k==173){zooms('-');};
    };


    function zooms(n){
      var obj, w, h;
      obj=d.getElementById("id_img");
      w=obj.width;
      h=obj.height;
//����� ����� ��������� ���/��� ������� � ��� �� ������ � ����
      if(n=='-'){w=w-c; h=h-c;}else{w=w+c; h=h+c;};
      obj.width=w;
      obj.height=h;
    };


  })();
</script>