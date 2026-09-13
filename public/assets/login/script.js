/* ============================================
   LOGIN — Script adaptado al controlador PHP
   ============================================ */
$(function () {
    'use strict';

    const $form     = $('#loginForm');
    const $username = $('#username');
    const $password = $('#password');
    const $btn      = $('#loginBtn');
    const $error    = $('#loginError');

    /* ----------------------------------------
       FOCUS INICIAL SUAVE
       ---------------------------------------- */
    setTimeout(function () {
        // Si hay usuario precargado (error), enfocar la contraseña
        if ($username.val() !== '') {
            $password.trigger('focus');
        } else {
            $username.trigger('focus');
        }
    }, 600);

    /* ----------------------------------------
       TOGGLE PASSWORD
       ---------------------------------------- */
    $(document).on('click keydown', '.toggle-password', function (e) {
        if (e.type === 'keydown' && e.key !== 'Enter' && e.key !== ' ') return;
        e.preventDefault();
        e.stopPropagation();

        const $icon  = $(this);
        const $input = $icon.closest('.input-container').find('input');
        const isPassword = $input.attr('type') === 'password';

        $input.attr('type', isPassword ? 'text' : 'password');
        $icon
            .toggleClass('fa-eye', !isPassword)
            .toggleClass('fa-eye-slash', isPassword)
            .attr('aria-label', isPassword ? 'Ocultar contraseña' : 'Mostrar contraseña');

        $input.trigger('focus');
    });

    /* ----------------------------------------
       FLOATING LABELS
       ---------------------------------------- */
    function handleInputState() {
        const $input = $(this);
        const hasValue = $input.val().length > 0;
        $input.toggleClass('has-value', hasValue);
        $input.removeClass('is-invalid');
        $error.addClass('d-none').text('');
    }

    $('.input-field').on('input focus blur', handleInputState);

    // Estado inicial (para autofill y valor precargado)
    $('.input-field').each(function () {
        if ($(this).val().length > 0) $(this).addClass('has-value');
    });

    /* ----------------------------------------
       VALIDACIÓN CLIENTE
       ---------------------------------------- */
    function showError(message, $input) {
        $error.text(message).removeClass('d-none');
        if ($input) {
            $input.addClass('is-invalid').trigger('focus');
            if (navigator.vibrate) navigator.vibrate(100);
        }
    }

    function setLoading(isLoading) {
        $btn.prop('disabled', isLoading).toggleClass('is-loading', isLoading);
        $btn.find('.btn-text').toggleClass('invisible', isLoading);
        $btn.find('.btn-loader').toggleClass('d-none', !isLoading);
    }

    /* ----------------------------------------
       SUBMIT — POST tradicional
       ---------------------------------------- */
    $form.on('submit', function (e) {
        $error.addClass('d-none').text('');

        const username = $.trim($username.val());
        const password = $password.val();

        // Validaciones locales (el server también valida)
        if (!username) {
            e.preventDefault();
            return showError('El usuario es obligatorio.', $username);
        }
        if (!password) {
            e.preventDefault();
            return showError('La contraseña es obligatoria.', $password);
        }
        if (password.length < 6) {
            e.preventDefault();
            return showError('La contraseña debe tener al menos 6 caracteres.', $password);
        }

        // Mostrar estado "cargando"
        setLoading(true);

        // Dejar que el form se envíe normalmente (POST a /login)
        return true;
    });

    /* ----------------------------------------
       ENTER EN USUARIO → focus password
       ---------------------------------------- */
    $username.on('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            $password.trigger('focus');
        }
    });

    /* ----------------------------------------
       RE-HABILITAR BOTÓN SI EL NAVEGADOR VUELVE ATRÁS
       ---------------------------------------- */
    window.addEventListener('pageshow', function () {
        setLoading(false);
    });
});
