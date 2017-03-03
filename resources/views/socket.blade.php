<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="{{ asset('js/socket.io.js') }}"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

        <script>
            var socket = io('http://localhost:3000');

            socket.on("test-channel:App\\Events\\MyEventNameHere", function(message){
                // increase the power everytime we load test route
//                $('#chat_box').append("<div>"+ message.data.name + ":" + message.data.msg+"</div>");
                $('#chat_box').append("<div>"+ message.data.doPlay +"</div>");

                console.log(message);
            });
            $(document).ready(function(){
                $('#sendMsg').click(function(){
                    var data = {
                        user: $('input[name=user]').val(),
                        msg: $('input[name=msg]').val(),
                        doplay: $('select[name=doPlay]').val(),
                        _token: '{{ csrf_token() }}'
                    };

                    if(data.user.length <= 0 || data.msg.length <= 0 || data.doPlay.length <= 0) {
                        alert('error msg');
                    }else {
                        $.ajax({
                            type: "POST",
                            url: "message",
                            data: data,
                            success: function() {
                                $('input[name=msg]').val("");
                                $('input[name=msg]').focus();
                                $('select[name=doPlay]').val("");
                            }
                        });
                    }
                });
            });

        </script>
    </head>
    <body>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Chat</h3>
            </div>
            <div id="chat_box" class="panel-body">
            </div>
            <div class="panel-footer">
                Name：<input name="user" value="" maxlength="15" size="15">
                Msg：<input name="msg" value="" size="50">
                PlayGame:<select name="doPlay">
                        <option value=""></option>
                        <option value="scissors">剪刀</option>
                    　  <option value="stone">石頭</option>
                        <option value="paper">布</option>
                    </select>
                <input id="sendMsg" type="button" value="Send">
            </div>
        </div>
    </body>
</html>
