<?php

if (isset($_POST['counts'])) {
    $counts=htmlspecialchars($_POST['counts']);

    print $counts;

}

else {
    ?>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>

        $(function() {

            $(document).ready(function() {


                $('#id_task8').submit(function() {
                    var $form = $(this);
                    var val = $("#id_of_counts").val();
                    //отправляю POST запрос и получаю ответ
                    $.ajax({
                        type: 'post',//тип запроса: get,post либо head
                        url: '/kost.php',//url адрес файла обработчика
                        data: 'counts=' + $('#id_of_counts', $form).val(),//параметры запроса
                        success: function (data) {//возвращаемый результат от сервера
                            $('#result').html(data);
                        }
                    });
                    return false;
                });
            });
        });
    </script>


    <form method="POST" action="" id="id_task8">
        <div>
            <div>
                <label for="id_of_counts">Enter the amount of passwords:</label>
            </div>
            <input id="id_of_counts" type="text" name="counts" value="Input me pls...">
        </div>
        <div>
            <input id="btn-task8" type="submit" name="generate" value="Generate!">
        </div>
    </form>

    <div id="result"></div>

<?php } ?>