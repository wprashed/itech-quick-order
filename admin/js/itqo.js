; (function ($) {
    $(document).ready(function () {

        $("#itqo_genpw").on('click', function () {
            $.post(itqo.ajax_url, { 'action': 'itqo_genpw', 'nonce': itqo.nonce }, function (data) {
                $("#password").val(data);
            });
        });
        $("#coupon").on('click', function () {
            if ($(this).attr('checked')) {
                $("#discount-label").html(itqo.dc);
                $("#discount").attr("placeholder", itqo.cc);
            } else {
                $("#discount-label").html(itqo.dt);
                $("#discount").attr("placeholder", itqo.dt);
            }
        });

        $("#email").on('blur', function () {
            if($(this).val()==''){
                return;
            }
            $("#first_name").val('');
            $("#last_name").val('');
            let email = $(this).val();
            //alert(itqo.ajax_url);
            $.post(itqo.ajax_url, { 'action': 'itqo_fetch_user', 'email': email, 'nonce': itqo.nonce }, function (data) {
                if ($("#first_name").val() == '') {
                    $("#first_name").val(data.fn);
                }
                if ($("#last_name").val() == '') {
                    $("#last_name").val(data.ln);
                }
                $("#phone").val(data.pn);
                $("#customer_id").val(data.id);

                if (!data.error) {
                    $("#first_name").attr('readonly', 'readonly');
                    $("#last_name").attr('readonly', 'readonly');
                    $("#password_container").hide();
                } else {
                    $("#password_container").show();
                    $("#first_name").removeAttr('readonly')
                    $("#last_name").removeAttr('readonly');
                }

            }, "json");
        });


        if ($('#itqo-edit-button').length > 0) {
            tb_show(itqo.pt, "#TB_inline?inlineId=itqo-modal&width=700");
        }
    });
})(jQuery);