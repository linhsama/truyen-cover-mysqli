<script>
    $(function() {
        $('#btn-register').on('click', function() {
            $.ajax({
                url: "/project-truyentranh/backend/auth/register.php",
                type: "post",
                dataType: "text",
                data: {
                    ten_hien_thi: $('#ten_hien_thi').val(),
                    ten_dang_nhap: $('#ten_dang_nhap').val(),
                    mat_khau: $('#mat_khau').val(),
                    trang_thai: $('#trang_thai').val(),
                    phan_quyen: $('#phan_quyen').val(),
                    anh_dai_dien: $('#anh_dai_dien').val(),
                    register: 'register'
                },
                success: function(result_register) {
                    $('#result_register').html(result_register);
                }
            });
        });

        $('#btn-login').on('click', function() {
            $.ajax({
                url: "/project-truyentranh/backend/auth/login.php",
                type: "post",
                dataType: "text",
                data: {
                    username: $('#username').val(),
                    password: $('#password').val(),
                    login: 'login'
                },
                success: function(result) {
                    $('#result').html(result);
                }
            });
        });

        $('#loginModal').on('hidden.bs.modal', function(event) {
            $("#form-login").trigger("reset");
            $.ajax({
                url: "/project-truyentranh/backend/auth/login.php",
                type: "post",
                dataType: "text",
                data: {
                    clear: 'clear'
                },
                success: function(result) {
                    $('#result').html(result);
                }
            });
        });


        $('#registerModal').on('hidden.bs.modal', function(event) {
            $("#form-register").trigger("reset");
            $.ajax({
                url: "/project-truyentranh/backend/auth/register.php",
                type: "post",
                dataType: "text",
                data: {
                    clear: 'clear'
                },
                success: function(result_register) {
                    $('#result_register').html(result_register);
                }
            });
        });

    });
</script>