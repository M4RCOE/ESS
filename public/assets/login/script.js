$(function() {
    setTimeout(() => {
        $('#username').trigger('focus');
    }, 1000);

    // toggle de contraseña
    $(document).on('click', '.toggle-password', function() {
        const $input = $(this).closest('.position-relative').find('input');
        const $icon = $(this);
        const isPassword = $input.attr('type') === 'password';
        $input.attr('type', isPassword ? 'text' : 'password');
        $icon.toggleClass('fa-eye fa-eye-slash');
    });

    const handleInputState = function() {
        const $label = $(this).next('.input-label');
        const hasValue = $(this).val().length > 0;
        $(this).toggleClass('has-value', hasValue);
        $label.toggleClass('has-value', hasValue);
    };

    $('.input-field')
        .on('input focus', handleInputState)
        .on('blur', handleInputState)
        .trigger('blur');
   
});
