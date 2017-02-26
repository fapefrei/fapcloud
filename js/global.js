var enableStickyNav = function() {

    /* Enable scroll follow */
    jQuery(window).on('scroll', function() {
        if (jQuery(window).scrollTop() > 18) {
            jQuery('nav').addClass('fixed');
            jQuery('body').css('margin-top', '77px');
        } else {
            jQuery('nav').removeClass('fixed');
            jQuery('body').css('margin-top', '20px');
        }
        //        console.log(jQuery(window).scrollTop());
    });
};

/* Display Notifications Modal Windows */
var enableNotifications = function() {

    notification('#account', '#modal-account');
    notification('#connexion', '#modal-connexion');
    notification('#help', '#modal-help');
    notification('#delete', '#modal-delete');
    notification('#changePromo', '#modal-changePromo');
    notification('#souvenir', '#modal-souvenir');
    notification('.document-link', '#modal-link-document');
    notification('.subject-link', '#modal-link-subject');
    notification('#system-status', '#modal-system-status');
    notification('.delete-post', '#modal-delete-post');

    notification_auto('#modal-document-unavailable');
    notification_auto('#modal-new');


    function notification(button, modal) {
        jQuery(document).on('click', button, function(e) {
            e.stopPropagation();
            jQuery(modal).show();
            jQuery('body').toggleClass('no-scroll');
            jQuery(".modal-container").addClass('openned', 300);
            jQuery(".modal").addClass('openned', 300);

            jQuery(".modal-container #close").on('click', function() {
                jQuery('body').removeClass('no-scroll');
                jQuery(".modal").removeClass('openned', 10, 'linear');
                jQuery(".modal-container").removeClass('openned', 300, 'linear', function() {
                    jQuery(".modal-container").hide();
                });
            });
            jQuery(".modal-container #valide-delete-post").on('click', function() {
                jQuery('body').removeClass('no-scroll');
                jQuery(".modal").removeClass('openned', 10, 'linear');
                jQuery(".modal-container").removeClass('openned', 300, 'linear', function() {
                    jQuery(".modal-container").hide();
                });
            });
        });
    }

    function notification_auto(modal) {
        /* Affichage au chargement */
        if (jQuery('.erreur-modal').length) {
            jQuery(modal).show();
            jQuery('body').toggleClass('no-scroll');
            jQuery(".modal-container").addClass('openned', 300);
            jQuery(".modal").addClass('openned', 300);

            jQuery(".modal-container #close").on('click', function() {
                jQuery('body').removeClass('no-scroll');
                jQuery(".modal").removeClass('openned', 10, 'linear');
                jQuery(".modal-container").removeClass('openned', 300, 'linear', function() {
                    jQuery(".modal-container").hide();
                });
            });
        }
    }
};

/* Display Action Views */
var enableActionView = function() {

    actionView('#test', '#action-view-test');
    actionView('#trend', '#action-view-trend');
    actionView('#vardump', '#action-view-vardump');
    actionView('#password-reset', '#action-view-password-reset');
    actionView('#cgu', '#action-view-cgu');
    actionView('#feedback', '#action-view-feedback');
    actionView('#signaler-probleme', '#action-view-signaler-probleme');
    actionView('.signaler', '#action-view-signaler-probleme');

    function actionView(button, modal) {
        jQuery(button).on('click', function(e) {
            e.stopPropagation();
            jQuery(modal).show();
            jQuery('body').toggleClass('no-scroll');
            jQuery(".action-view-container").addClass('openned', 300);
            jQuery(".action-view").addClass('openned', 300);

            jQuery(".action-view-container #close").on('click', function() {
                jQuery('body').removeClass('no-scroll');
                jQuery(".action-view").removeClass('openned', 300, 'linear');
                jQuery(".action-view-container").removeClass('openned', 300);
                setTimeout(function(){
                    jQuery(".action-view-container").hide();
                }, 310);
            });
        });
    }
};

function closeActionView(modal){
        jQuery('body').removeClass('no-scroll');
        jQuery(".action-view").removeClass('openned', 300, 'linear');
        jQuery(".action-view-container").removeClass('openned', 300);
        setTimeout(function(){
            jQuery(".action-view-container").hide();
        }, 310);
}

var enableUploadView = function() {

    // Draggable
    // jQuery(".upload-view").draggable();

    actionView('#post', '#upload-view');

    function actionView(button, modal) {
        jQuery(button).on('click', function(e) {
            e.stopPropagation();
            jQuery(modal).show();
            jQuery('body').toggleClass('no-scroll');
            jQuery(".upload-container").addClass('openned', 300);
            jQuery(".upload-view").addClass('openned', 300);

            jQuery(".upload-container #close").on('click', function() {
                jQuery('body').removeClass('no-scroll');
                jQuery(".upload-view").removeClass('openned', 300);
                jQuery(".upload-container").removeClass('openned', 300);

                setTimeout(function(){
                    jQuery(modal).hide();
                }, 310);
                
            });
        });
    }

    jQuery('#upload-choose-file').on('click', function(){
        if( jQuery(this).hasClass('selected') ){
            jQuery(this).removeClass('selected');
            jQuery('#post-text').attr('placeholder','Quoi de neuf ?');
            jQuery('.upload-type-text').show();
            jQuery('.upload-type-link').hide();
            jQuery('.upload-type-file').hide();
        }else{
            jQuery(this).addClass('selected');
            jQuery('#upload-choose-link').removeClass('selected');
            jQuery('#post-text').attr('placeholder','Dites quelque chose à propos de ceci...');

            jQuery('.upload-type-text').hide();
            jQuery('.upload-type-link').hide();
            jQuery('.upload-type-file').show();
        }
    });

    jQuery('#upload-choose-link').on('click', function(){
        if( jQuery('#upload-choose-link').hasClass('selected') ){
            jQuery(this).removeClass('selected');
            jQuery('#post-text').attr('placeholder','Quoi de neuf ?');
            jQuery('.upload-type-text').show();
            jQuery('.upload-type-file').hide();
            jQuery('.upload-type-link').hide();
        }else{
            jQuery(this).addClass('selected');
            jQuery('#upload-choose-file').removeClass('selected');
            jQuery('#post-text').attr('placeholder','Dites quelque chose à propos de ceci...');

            jQuery('.upload-type-text').hide();
            jQuery('.upload-type-file').hide();
            jQuery('.upload-type-link').show();
        }
    });

    jQuery('#post-text').on('keyup', function(){
        console.log('fired');
        var len = jQuery('#post-text').val().length;
        var displayed = 160;
        var total = displayed - len;
        jQuery('.total-text-count').html(total);
        if (total <= 10) {
            jQuery('.total-text-count').addClass('over');
        } else {
            jQuery('.total-text-count').removeClass('over');
        }
    });
};

/* Message */
function Message(text){
    jQuery('.message p').html(text);
    jQuery('.message').addClass('openned');
    setTimeout(
    function() {
            jQuery('.message').removeClass('openned');
    }, 4000);
}

// var enableLogin = function(){
//     jQuery('#connexion').on('click', function(){
//        // e.preventDefault;
//        // jQuery('header').css('background','inherit');
//        // jQuery('.form-connexion').fadeIn(100);
//     });
//     jQuery('.form-connexion').submit(function(event){
//         var stay = '0';
//         if (jQuery('#stay').is(":checked")){
//             stay = '1';
//         }

//         jQuery.ajax({
//             type: 'POST',
//             dataType: 'json',
//             url: jQuery(this).attr('action'),
//             data: {  
//                 'action': 'ajaxlogin',
//                 'username': jQuery('#user_login').val(), 
//                 'password': jQuery('#user_password').val(),
//                 'remember': jQuery('#stay').val(),
//                 'stay': stay
//             },
//             beforeSend: function(){
//                 jQuery(':submit').attr('value','Vérification...');
//                 jQuery('#oublie-mdp').fadeOut();
//                 jQuery('#loader').toggle();
//             },
//             success: function(data){

//             },
//             complete: function(){
//                 jQuery(':submit').attr('value','se connecter');
//                 jQuery('#loader').toggle();
//             },
//             error: function(){
//                 jQuery('#oublie-mdp').fadeIn();
//             }
//         });
//         event.preventDefault();
//     });

//     /* Add "@efrei.net" to input */
//     jQuery('#username').keyup(function(e){
//         var value = jQuery(this).val();
//         if( e.which == 192 ) {
//             jQuery(this).val(value + 'efrei.net');    
//         }
//     });
// };

var enableSmoothScrolling = function() {
    //Smooth scrolling
    jQuery('a[href*=#]:not([href=#])').click(function() {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = jQuery(this.hash);
            target = target.length ? target : jQuery('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                jQuery('html,body').animate({
                    scrollTop: target.offset().top
                }, 1000);
                return false;
            }
        }
    });
};

var enableInscription = function() {

    // EMAIL FORMAT 
    jQuery('#email-efrei').on('change', function() {
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: jQuery('form').attr('action') + '?action=valideEmail',
            data: {
                'email': jQuery('#email-efrei').val()
            },
            beforeSend: function() {
                jQuery('#email-efrei').removeClass('has-error');
                jQuery('#email-efrei').closest('div[class="input-card"]').attr('data-error', '');
                jQuery('#email-efrei').next('.error').text('');
            },
            success: function(data) {},
            complete: function() {},
            error: function(xhr) {
                new Message(xhr.responseText);
                jQuery('#email-efrei').addClass('has-error');
                jQuery('#email-efrei').closest('div[class="input-card"]').attr('data-error', '1');
            }
        });
    });

    // SIMILAR EMAILS
    jQuery('#email-confirm').on('change', function() {
        var email = jQuery('#email-efrei').val();
        if( jQuery(this).val() != email ){
            jQuery('#email-efrei').addClass('has-error');
            jQuery('#email-confirm').addClass('has-error');
            new Message('Les 2 adresses emails ne sont pas identiques');
            jQuery('#email-efrei').closest('div[class="input-card"]').attr('data-error', '1');

        }else{
            jQuery('#email-efrei').removeClass('has-error');
            jQuery('#email-confirm').removeClass('has-error');
            jQuery('#email-efrei').closest('div[class="input-card"]').attr('data-error', '');
        }
    });

    // SIMILAR PASSWORD
    jQuery('#password-confirm').on('change', function() {
        if( jQuery('#password-confirm').val() !== jQuery('#password').val() ){
            jQuery('#password').addClass('has-error');
            jQuery('#password-confirm').addClass('has-error');
            new Message('Les 2 mots de passe ne sont pas identiques');
            jQuery('#password').closest('div[class="input-card"]').attr('data-error', '1');

        }else{
            jQuery('#password').removeClass('has-error');
            jQuery('#password-confirm').removeClass('has-error');
            jQuery('#password').closest('div[class="input-card"]').attr('data-error', '');
        }
    });

    // jQuery('#promo').on('change', function() {
    //     var dteNow = new Date();
    //     var intYear = dteNow.getFullYear();

    //     if ( jQuery(this).val() == "L1"){
    //         intYear = intYear + 5;
    //         jQuery('#annee').attr('placeholder', intYear);
    //     } 
    //     if ( jQuery(this).val() == "L2"){
    //         intYear = intYear + 4;
    //         jQuery('#annee').attr('placeholder', intYear);
    //     } 
    //     if ( jQuery(this).val() == "L3"){
    //         intYear = intYear + 3;
    //         jQuery('#annee').attr('placeholder', intYear);
    //     }  
    //     if ( jQuery(this).val() == "M1"){
    //         intYear = intYear + 2;
    //         jQuery('#annee').attr('placeholder', intYear);
    //     } 
    //     if ( jQuery(this).val() == "M2"){
    //         intYear = intYear + 1;
    //         jQuery('#annee').attr('placeholder', intYear);
    //     }
    // });

    /* AVATAR */
    jQuery('.avatar').on('click', function(){
        jQuery('.avatar').not(this).removeClass('selected');
        jQuery(this).addClass('selected');
        var avatar = jQuery(this).attr('data-avatar');
        jQuery('#avatar-input').attr('value', avatar);
    });

    /* COLOR */
    jQuery('.color-selector ').on('click', function(){
        jQuery('.color-selector ').not(this).removeClass('selected');
        jQuery(this).addClass('selected');
        var color = jQuery(this).attr('data-color');
        jQuery('#color-input').attr('value', color);
    });

    // /* */
    // jQuery('#username').keyup(function(e){
    //     var value = jQuery(this).val();
    //     if( e.which == 192 ) {
    //         jQuery(this).val(value + 'efrei.net');    
    //     }
    // });

    /* MAIL */
    jQuery('#email-efrei').on('change', function(e){
        e.preventDefault();
        if( jQuery(this).val().length > 0){
                jQuery(this).removeClass('has-error');
                jQuery.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: '/functions.php?action=checkEmail',
                    data: {
                        'email': jQuery(this).val()
                    },
                    beforeSend: function() {
                        jQuery('#email-efrei').removeClass('has-error');
                        jQuery('#email-efrei').closest('div[class="input-card"]').attr('data-error', '');
                    },
                    success: function(data) {},
                    complete: function(data) {},
                    error: function(xhr) {
                        jQuery('#email-efrei').addClass('has-error');
                        new Message('Cet email est déja utilisé.');
                        jQuery('#email-efrei').closest('div[class="input-card"]').attr('data-error', '1');
                    }
                });
        }
    });

    /* PSEUDO */
    jQuery('#pseudo').keyup(function(e){
        e.preventDefault();
        if( jQuery(this).val().length > 0){
            if ( !jQuery(this).val().match(/[a-zA-Z0-9_]+$/) ){
                jQuery(this).addClass('has-error');
                new Message('Caractères interdits');
            }else{
                jQuery(this).removeClass('has-error');
                jQuery.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: '/functions.php?action=checkPseudo',
                    data: {
                        'pseudo': jQuery(this).val()
                    },
                    beforeSend: function() {
                        jQuery('#pseudo').removeClass('has-error');
                        jQuery('#pseudo').closest('div[class="input-card"]').attr('data-error', '');
                    },
                    success: function(data) {},
                    complete: function(data) {},
                    error: function(xhr) {
                        jQuery('#pseudo').addClass('has-error');
                        new Message('Ce pseudo n\'est pas disponible.');
                        jQuery('#pseudo').closest('div[class="input-card"]').attr('data-error', '1');
                    }
                });
            }
        }
    });

    jQuery('#form-account').on('submit', function(e){
        e.preventDefault();
        if( !jQuery('.color-selector.selected').length ){
            new Message('Vous devez choisir une couleur.');
        }else if( !jQuery('.avatar.selected').length ){
            new Message('Vous devez choisir un avatar.');
        }else if( !jQuery('.slider-label-active').length){
            new Message('Vous devez choisir une promotion.');
        }else{

            var ok;
            
            jQuery(".input-card").each( function(){
                if( jQuery( this ).attr('data-error').val == 1 ){
                    new Message('Des erreurs persistes.');
                    ok = false;
                }else{
                    ok = true;
                }
                return ok;
            });

            // if( jQuery('#form-account').checkValidity() === false ){
            //     ok = false;
            // }

            if( ok === true ){
                jQuery.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: '/functions.php?action=create_new_account',
                    data: jQuery('#form-account').serialize(),
                    beforeSend: function() {
                        jQuery(':submit').attr('value', 'Chargement...');
                    },
                    success: function(data) {
                        location.reload();
                    },
                    complete: function(data) {
                        jQuery(':submit').attr('value', 'Créer mon compte');
                    },
                    error: function(xhr) {
                        jQuery('#pseudo').addClass('has-error');
                        new Message('Erreur');
                    }
                });
            }else{
                new Message('Des erreurs persistes.');
            }
        }
    });

};

/* User Dropdown top bar */
var enableUserDropdownMenu = function() {
    jQuery('.user-menu').on('click', function(e) {
        e.stopPropagation();
        jQuery('.user-dropdown').toggleClass('openned');
    });

    jQuery(document).click(function() {
        jQuery('.user-dropdown').removeClass('openned');
    });
};

/* File cards openning */
var enableFileCard = function() {
    jQuery('.file-card').on('click', function(e) {
        e.stopPropagation();
        jQuery('.file-card').not(this).removeClass('openned');
        jQuery('.file-card').not(this).children('.file-infos').removeClass('openned');
        jQuery(this).toggleClass('openned');
        jQuery(this).children('.file-infos').toggleClass('openned');
    });

    jQuery(document).click(function() {
        jQuery('.file-card').removeClass('openned');
        jQuery('.file-card').children('.file-infos').removeClass('openned');
    });
};

/* List slides (profile > settings) */
var enableListSlide = function() {
    jQuery('.top-list').on('mousedown', function(e) {
        e.stopPropagation();

        // Reset
        jQuery('.top-list').not(this).next('.bottom-list').slideUp(200);
        jQuery('.top-list').not(this).removeClass('openned');

        // Open
        jQuery(this).next('.bottom-list').slideToggle(200);
        jQuery(this).toggleClass('openned');

    });
};

var enableAvatarSelect = function() {
    jQuery('.avatar').on('click', function() {
        jQuery('.avatar').removeClass('selected');
        jQuery(this).addClass('selected');

        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: jQuery('.avatar-container').attr('data-ajax-url') + '?action=selectAvatar',
            data: {
                'avatar': jQuery(this).attr('data-avatar'),
                'pseudo': jQuery('.user-card').attr('data-user')
            },
            beforeSend: function() {},
            success: function(data) {
                location.reload();
            },
            complete: function() {},
            error: function(xhr) {
                new Message('Erreur : ' + xhr.responseText);
            }
        });

    });
};

var enableColorSelect = function() {
    jQuery('.color-picker li').on('click', function() {
        var color = jQuery(this).attr('data-color');
        jQuery('li').removeClass('selected');
        jQuery(this).addClass('selected');

        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: jQuery('.color-picker').attr('data-ajax-url') + '?action=selectColor',
            data: {
                'color': color,
                'pseudo': jQuery('.user-card').attr('data-user')
            },
            beforeSend: function() {
                // console.log('Before');
            },
            success: function(data) {
                console.log(data);
                location.reload();
            },
            complete: function() {},
            error: function(xhr) {
                new Message('Error : ' + xhr.responseText);
            }
        });

    });
};

/* User login */
var enableLogin = function() {
    jQuery('#login-form').on('submit', function(e) {
        e.preventDefault();
        var stay = '0';
        if (jQuery('#stay').is(":checked")) {
            stay = '1';
        }
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: jQuery('#login-form').attr('action') + '?action=login',
            data: {
                'username': jQuery('#user_login').val(),
                'password': jQuery('#user_password').val(),
                'remember': stay
            },
            beforeSend: function() {
                // Reset error CSS
                jQuery('#user_password').removeClass('has-error');
                jQuery('#user_login').removeClass('has-error');
                jQuery('#user_login').removeClass('animated shake');
                jQuery('#user_password').removeClass('animated shake');

                jQuery('#login-form :submit').attr('value', 'Vérification...');
            },
            success: function(data) {
                jQuery('#login-form :submit').attr('value', 'Connexion...');
                window.location.href = data.redirect;
            },
            complete: function() {},
            error: function(xhr, textStatus) {
                jQuery('#login-form :submit').attr('value', 'Se connecter');
                var data = JSON.parse(xhr.responseText);
                new Message(data['erreur']);
                // Display the error
                jQuery('#erreur').html(data['erreur']);
                // Email incorrect
                if (data['erreur'] == 'Adresse email incorrecte') {
                    jQuery('#user_login').addClass('has-error');
                    jQuery('#user_login').addClass('animated shake');
                }
                // Mot de passe incorrect
                if (data['erreur'] == 'Mot de passe incorrect') {
                    jQuery('#user_password').addClass('has-error');
                    jQuery('#user_password').addClass('animated shake');
                }
            }
        });

    });
};

/* User logout */
var enableLogout = function() {
    jQuery('#logout').on('click', function(e) {
        e.preventDefault();
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/functions.php?action=logout',
            data: {},
            beforeSend: function() {},
            success: function(data) {
                window.location.href = data.redirect;
            },
            complete: function() {},
            error: function(xhr) {
                new Message('Erreur : ' + xhr.responseText);
            }
        });
    });
};

// var enableSelectPopup = function(){

//     jQuery('#pp').on('click', function(e){
//         jQuery('.select-popup').show();
//         var mouseX, mouseY;
//         mouseX = e.pageX;
//         mouseY = e.pageY;
//         jQuery('.select-popup').css('top',mouseY);
//         jQuery('.select-popup').css('left',mouseX);
//     });

//     jQuery(document).click( function(){
//         // jQuery('.select-popup').hide();
//     });
// };

/* Change session promotion (for VIP users) */
var enableChangePromo = function() {
    jQuery('.modal li').on('click', function() {
        var promo = jQuery(this).attr('data-promo');
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/functions.php?action=changePromotion',
            data: {
                'promo': promo
            },
            beforeSend: function() {
                // console.log('Before');
            },
            success: function(data) {
                location.reload();
            },
            complete: function() {},
            error: function(xhr) {
                new Message('Erreur : ' + xhr.responseText);
            }
        });
    });
};

/* Display all subjects from current year */
var enableAllMatieres = function() {
    jQuery('#all-matieres').on('click', function() {
        jQuery('.all-matieres').slideToggle();
    });
};

var enablePasswordChange = function() {
    jQuery('#passchange').on('submit', function(e) {
        e.preventDefault();
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/functions.php?action=changePassword',
            data: {
                'pass': jQuery('#pass').val(),
                'pass1': jQuery('#pass1').val(),
                'pass2': jQuery('#pass2').val(),
                'pseudo': jQuery('.user-card').attr('data-user'),
                'truepass': jQuery('#passT').val()
            },
            beforeSend: function() {
                jQuery(':submit').attr('value', 'Vérification...');
            },
            success: function(data) {
                new Message('Votre mot de passe a été changé.');
            },
            complete: function(data) {
                jQuery(':submit').attr('value', 'Valider');
            },
            error: function(xhr) {
                new Message('Erreur : '+xhr.responseText);
            }
        });
    });
};

var enableFavoris = function() {
    jQuery('.favoris').on('click', function(e) {
        var that = jQuery(this);
        e.preventDefault();
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/functions.php?action=add_favoris',
            data: {
                'matiere': jQuery('.favoris').attr('data-matiere'),
                'user': jQuery('.user-menu').attr('data-user')
            },
            beforeSend: function() {
                if (jQuery('.favoris-list').length) {
                    jQuery(that).parent('.matiere').parent('a').hide();
                    console.log(that);
                    console.log('hided');
                }
            },
            success: function(data) {
                new Message('Favoris ajouté');
                jQuery('.favoris-icon i').html('star');
            },
            complete: function(data) {
                jQuery('#error').html(data.responseText);
            },
            error: function(xhr) {
                new Message('Favoris supprimé');
                jQuery('.favoris-icon i').html('star_border');
            }
        });
    });
};

/* Download Script */
var enableDownload = function() {

    jQuery('.download-button').on('click', function(e) {
        e.preventDefault();
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/functions.php?action=download',
            data: {
                'document': jQuery('.download-button').attr('data-document-id')
            },
            beforeSend: function() {},
            success: function(data) {
                window.location.href = jQuery('.download-button').attr('href');
            },
            complete: function(data) {},
            error: function(xhr) {
                new Message('Error : ' + xhr.responseText);
            }
        });

    });
};

var enablePasswordReset = function() {

    jQuery('#password-reset-form').on('submit', function(e) {
        e.preventDefault();
        e.stopPropagation();
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/functions.php?action=password_reset',
            data: {
                'email': jQuery('#password-reset-form #email').val()
            },
            beforeSend: function() {
                jQuery('#email').removeClass('has-error');
                jQuery('#email').removeClass('animated shake');
            },
            success: function(data) {
                jQuery('body').removeClass('no-scroll');
                jQuery(".action-view").removeClass('openned', 300, 'linear');
                jQuery(".action-view-container").removeClass('openned', 300, 'linear', function() {
                    jQuery(".action-view-container").hide();
                });
                new Message('Un mail vous a été envoyé sur "'+data+'".');
            },
            complete: function(data) {},
            error: function(xhr) {
                jQuery('#email').addClass('has-error');
                jQuery('#email').addClass('animated shake');
                new Message('Erreur : ' + xhr.responseText);
            }
        });
    });

    jQuery('#new-password-choice .submit').on('click', function(e) {
        e.preventDefault();
        var pass1 = jQuery('#pass1').val();
        var pass2 = jQuery('#pass2').val();

        if (pass1 == pass2) {
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/functions.php?action=password_reset_new',
                data: {
                    'user': jQuery('#user').val(),
                    'password': jQuery('#pass1').val()
                },
                beforeSend: function() {

                },
                success: function(data) {
                    window.location.href = '/';
                },
                complete: function(data) {},
                error: function(xhr) {
                    new Message('Error : ' + xhr.responseText);
                }
            });
        } else {
            new Message('Passwords don\'t match');
        }
    });
};

/* File checkbox selection */
var enableFileTypeSelection = function() {
    jQuery('.file-type-selection li').on('click', function() {
        jQuery('.file-type-selection li').removeClass('selected');
        jQuery(this).addClass('selected');
        var selectedType = jQuery(this).attr('id');
        jQuery('.file-card').each(function() {
            if (selectedType == 'all') {
                jQuery('.file-card').show();
            } else {
                if (jQuery(this).attr('data-file-type') != selectedType) {
                    jQuery(this).hide();
                } else {
                    jQuery(this).show();
                }
            }
        });
    });

    // jQuery('.file-type-selection li').each(function() {
    //     var selectedType = jQuery(this).attr('id');
    //     var that = jQuery(this);

    //     jQuery('.file-card').each(function() {
    //         var lengthed = jQuery(this).attr('data-file-type', selectedType).length;
    //     });
    //         jQuery(that).append(lengthed+selectedType);
    // });

};

/* TABS SELECTION */
var enableTabs = function() {

    jQuery('.tab-selection li').on('click', function() {
        // Add selected class
        jQuery('.tab-selection li').removeClass('selected');
        jQuery(this).addClass('selected');

        // Display correct tab
        var tab = jQuery(this).attr('data-section');
        jQuery('section').removeClass('selected');
        jQuery('#'+tab).addClass('selected');

    });
};

/* Ajax search */
var enableLiveSearch = function() {

    jQuery('#search').on('submit', function(e) {
        e.preventDefault();
    });

    jQuery(document).click(function() {
        jQuery('#live-input').val('');
        jQuery('#live-result').hide();
        jQuery('#search-delete').hide();
    });

    // Texte entré
    jQuery('#live-input').keyup(function() {
        var input = jQuery(this).val();
        if (input.length > 2) {
            jQuery('#live-result').show();
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/functions.php?action=search',
                data: {
                    'keyword': input
                },
                beforeSend: function() {},
                success: function(data) {
                    var len = data.length;
                    var txt = "";
                    for (var i = 0; i < len; i++) {
                        if (data[i].name && data[i].codename) {
                            txt += '<a href="/single-matiere.php?subject=' + data[i].codename + '"><li>' + data[i].name + ' - ' + data[i].annee + '</li></a>';
                        }
                    }
                    if (txt !== "") {
                        jQuery('#live-result ul').html(txt);
                    }
                },
                complete: function(data) {},
                error: function(xhr) {
                    jQuery('#live-result ul').html('<li>' + xhr.responseText + '</li>');
                }
            });
        }

        if (input.length === 0) {
            jQuery('#live-result').hide();
            jQuery('#search-delete').hide();
        }

        if (input.length >= 1) {
            jQuery('#search-delete').show();
        }

        jQuery('#search-delete').mousedown(function() {
            jQuery('#live-input').val('');
            jQuery('#live-result').hide();
            jQuery(this).hide();
        });
    });
};

// var testUpdateTime = function() {
//     var elements = document.querySelectorAll('.datetime[data-time]'),
//         updateDates = function() {
//             Array.prototype.forEach.call(elements, function(entry) {
//                 var out = '';
//                 // ...
//                 entry.textContent = out;
//             });
//             setTimeout(updateDates, 1000 * 60);
//         };
//     setTimeout(updateDates, 1000 * 60);
// };


var enableNotificationCount = function() {
    // var count = jQuery('.notification').length;
    // if (count === 0) { jQuery('#nav-notifications').addClass('hidden'); }
    // jQuery('#nav-notifications').attr('data-notification', count);
    
    // jQuery.ajax({
    //     type: 'POST',
    //     dataType: 'json',
    //     url: '/functions.php?action=get_mention_number',
    //     beforeSend: function() {
    //         jQuery('#nav-notifications').addClass('hidden');
    //     },
    //     success: function(data) {
    //         jQuery('#nav-notifications').attr('data-notification', data);
    //     },
    //     complete: function(data) {},
    //     error: function(xhr) {}
    // });
};

/* LIKES */
var enableLike = function() {
    
    jQuery(document).on('click', '.like', function() {
        var that = jQuery(this);
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/functions.php?action=like',
            data: {
                'document': jQuery(that).attr('data-document'),
                'user': jQuery('.user-menu').attr('data-user')
            },
            beforeSend: function() {},
            success: function(data) {
                jQuery(that).addClass('liked');

                var total = jQuery(that).siblings('.like-number').html();
                if (total === '') {
                    total = 1;
                } else {
                    total = parseInt(total, 10) + 1;
                }
                jQuery(that).siblings('.like-number').html(total);

            },
            complete: function(data) {},
            error: function(xhr) {
                jQuery(that).removeClass('liked');

                var total = jQuery(that).siblings('.like-number').html();
                total = parseInt(total, 10) - 1;
                if (total === 0) { total = null; }
                jQuery(that).siblings('.like-number').html(total);
            }
        });
    });
};

/* MORE MENU ON POSTS */
var enableMore = function() {

    jQuery(document).on('click', '.more', function(e) {
        e.stopPropagation();
        jQuery(this).parent('.actions-list').siblings('.more-menu').toggle();
    });

    jQuery(document).click(function() {
        jQuery('.more-menu').hide();
    });

    jQuery(document).on('click', '.subject-link', function() {
        var link = jQuery(this).attr('data-link');
        jQuery('#modal-link-subject input').val(link);
    });

    jQuery(document).on('click', '.document-link', function() {
        var link = jQuery(this).attr('data-link');
        jQuery('#modal-link-document input').val(link);
    });
};

var enableMAJ = function(){
    var promotion;
    var color;
    var avatar;
    // Promo
    jQuery('.btn').on('click', function() {
        promotion = jQuery(this).attr('data-promo');
        jQuery('.part-one').fadeOut('500', function(){
            jQuery('.part-two').fadeIn('500');
        });
        return promotion;
    });
    // Color
    jQuery('.color-picker .color-selector').on('click', function() {
        color = jQuery(this).attr('data-color');

        jQuery('.part-two').fadeOut('500', function(){
            jQuery('.part-three').fadeIn('500');
        });
        return color;
    });
    // Avatar
    jQuery('.avatar-container .avatar').on('click', function() {
        avatar = jQuery(this).attr('data-avatar');
        jQuery('.part-three').fadeOut('500', function(){
            jQuery('.part-four').fadeIn('500');
        });

        setTimeout(
        function() {
            // Ajax
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/functions.php?action=maj',
                data: {
                    'promo': promotion,
                    'color': color,
                    'avatar': avatar,
                    'user': jQuery('h1').attr('data-user')
                },
                beforeSend: function() {},
                success: function(data) {
                    window.location.href = data.redirect;
                },
                complete: function(data) {},
                error: function(xhr) {
                    alert('Une erreur est survenue lors de la mise à jour de votre compte.');
                }
            });
        }, 3000);
    });
};

/* FILE UPLOAD VIEW*/
var enableFileUpload = function(){

    jQuery('#form-file-upload').on('submit', function(e){
        e.preventDefault();

        // Create a new FormData object.
        var formData = new FormData();

        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData: false, 
            url: '/upload.php',
            // data: jQuery('#form-file-upload').serialize(),
            beforeSend: function() {
                jQuery(".upload-content-inner .loader").show();
                jQuery(':submit').attr('value','Publication...');
            },
            success: function(data) {
                new Message('Votre document a été ajouté !');
                jQuery('#form-file-upload').find("input[type=text], input[type=file], textarea, select").val('');

                jQuery('body').removeClass('no-scroll');
                jQuery(".upload-view").removeClass('openned', 10, 'linear');
                jQuery(".upload-container").removeClass('openned', 300, 'linear', function() {
                    jQuery(".upload-container").hide();
                });
            },
            complete: function(data) {
                jQuery(".upload-content-inner .loader").hide();
                jQuery(':submit').attr('value','Publier');
            },
            error: function(xhr) {
                var data = JSON.parse(xhr.responseText);
                new Message('Erreur : '+data['erreur']);
                // new Message('Erreur : '+xhr.responseText);
            }
        });
    });
};

/* DELETE POST FROM TIMELINE */
var enableDeletePost = function(){

    jQuery(document).on('click', '.delete-post', function(){
        var postid = jQuery(this).attr('data-post-id');
        jQuery('#modal-delete-post').attr('data-post-id', postid);
    });

    jQuery('#valide-delete-post').on('click',function(){
        var postid = jQuery(this).parents('.modal-container').attr('data-post-id');

        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/functions.php?action=deletePost',
            data: {
               'post-id': postid
            },
            beforeSend: function() {},
            success: function(data) {
                // location.reload();
                jQuery('.post[data-post-id="'+postid+'"]').fadeOut('2500');
                new Message('Votre post a été supprimé.');
            },
            complete: function(data) {},
            error: function(xhr) {
            }
        });
    });
};

/* SIGNALER UN PROBLEME */
var signalerProbleme = function(){
    jQuery('#form-signaler').on('submit', function(e){
        e.preventDefault();
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/functions.php?action=SignalerProbleme',
            data: jQuery('#form-signaler').serialize(),
            beforeSend: function() {},
            success: function(data) {
                new Message('Merci, votre signalement a été envoyé.');
                new closeActionView('#action-view-signaler-probleme');
                jQuery('#form-signaler')[0].reset();
            },
            complete: function(data) {},
            error: function(xhr) {
                new Message('Erreur : '+xhr.responseText);
            }
        });
    });
};


/* INTERNET CONNEXION CHECK */
function hostReachable() {

  // Handle IE and more capable browsers
  var xhr = new ( window.ActiveXObject || XMLHttpRequest )( "Microsoft.XMLHTTP" );
  var status;

  // Open new request as a HEAD to the root hostname with a random param to bust the cache
  xhr.open( "HEAD", "//" + window.location.hostname + "/?rand=" + Math.floor((1 + Math.random()) * 0x10000), false );

  // Issue request and handle response
  try {
    xhr.send();
    return ( xhr.status >= 200 && (xhr.status < 300 || xhr.status === 304) );
  } catch (error) {
    return false;
  }

}

// window.setInterval(function(){

//     if ( hostReachable() === false ){
//         new Message('<strong>You seems to be offline.</strong><br/>Please check your internet connexion.');
//     }

// }, 10000);


var enableAccountDeletion = function(){
    jQuery('#modal-delete #valide').on('click', function(){
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/functions.php?action=DeleteAccount',
            data: {

            },
            beforeSend: function() {},
            success: function(data) {
                new Message('Suppression...');
            },
            complete: function(data) {},
            error: function(xhr) {
                new Message('Erreur '+xhr.status+' : '+xhr.responseText);
            }
        });
    });
};

var enableTimeline = function(){

    // On document loaded
    get_posts();
    jQuery('.fin-de-liste').hide();

    function get_posts(){
        // Si ajax non en cours + resultats non chargés entièrement
        if( (jQuery('.posts-list').attr('data-ajax') != '1') && (jQuery('.posts-list').attr('data-ajax') != '2')){
            jQuery.ajax({
                type: 'POST',
                dataType: 'HTML',
                url: 'parts/main-function-timeline.php',
                data: {
                    'promotion': jQuery('.posts-list').attr('data-promo'),
                    'offset': jQuery('.posts-list').attr('data-offset'),
                    'lastlogin': jQuery('.posts-list').attr('data-lastlogin')
                },
                beforeSend: function() {
                    // Signal Requète Ajax en cours
                    jQuery('.posts-list').attr('data-ajax', '1');
                    // Show loader
                    jQuery('.post-loader').show();
                    // Hide fin-de-liste
                    jQuery('.fin-de-liste').hide();
                },
                success: function(textStatus) {
                    jQuery('.post-empty').hide();
                    jQuery(textStatus).insertBefore('.posts-list .post-loader');
                    // Update offset
                    var offset_prev = parseInt(jQuery('.posts-list').attr('data-offset'), 10);
                    jQuery('.posts-list').attr('data-offset', offset_prev+3);
                    // Fin de requète ajax
                    jQuery('.posts-list').attr('data-ajax', '0');
                },
                complete: function(data) {
                    // Hide loader when results charged
                    jQuery('.post-loader').hide();
                },
                error: function(xhr) {

                    if( jQuery('.post-empty').length ){
                        // Show end list
                        jQuery('.fin-de-liste').show();
                        // No more results
                        jQuery('.posts-list').attr('data-ajax', '2');
                    }else{
                        jQuery(xhr.responseText).insertBefore('.posts-list .post-loader');
                        jQuery('.posts-list').attr('data-ajax', '0');
                    }
                }
            });

        }else{
            console.log('Ajax Timeline en cours');
        }
    }

    // Déclencheur scroll
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() == $(document).height()) {
            get_posts();
        }
    });

};

jQuery(document).ready(function() {

    /* Main login/logout */
    enableLogin();

    enableLogout();
    
    /* Notification count for tab */    
    enableNotificationCount();

    /* User Dropdown */
    enableUserDropdownMenu();

    /* Download Script */
    enableDownload();

    enableFileCard();

    /* Live search */
    enableLiveSearch();

     // Notification system 
    enableNotifications();

    /* Action view window */
    enableActionView();

    /* Ajout / Suppression de favoris */
    enableFavoris();

    enableSmoothScrolling();

    /*---- UPLOAD ----*/
    enableUploadView();

    enableFileUpload();

    /* Sticky navigation bar home */
    if (jQuery('#template-home').length) {
        enableStickyNav();
    }

    if (jQuery('#template-homepage').length) {
        jQuery('#nav-home a').addClass('current');

        enableTimeline();

        enableChangePromo();
        enableAllMatieres();
        // testUpdateTime();
        enableLike();
        enableMore();
        enableDeletePost();
        signalerProbleme();

    }

    if (jQuery('#template-profil').length) {
        /* Liste déroulabnte paramètres */
        enableListSlide();
        /* Selection avatar profil */
        enableAvatarSelect();
        /* Selection de couleur */
        enableColorSelect();
        /* Changement mot de passe */
        enablePasswordChange();

        enableLike();
        enableMore();
        enableTabs();

        enableAccountDeletion();
    }

    if (jQuery('#template-hashtag').length) {
        enableLike();
        enableMore();
        enableDeletePost();
    }

    if (jQuery('#template-notifications').length) {
        jQuery('#nav-notifications a').addClass('current');
    }

    if (jQuery('#template-matiere').length) {
        enableFileTypeSelection();
    }

    if (jQuery('#template-login').length) {
        enablePasswordReset();
    }

    if (jQuery('#template-reset').length) {
        enablePasswordReset();
    }

    if (jQuery('#template-single-document').length) {
        enableLike();
        enableMore();    
    }

    if (jQuery('#template-compte').length) {
        enableInscription();
    }

    if (jQuery('#template-maj').length) {
        enableMAJ();
    }    

    if (jQuery('#template-homepage').length) {

        /* Enable Filer plugin */
        jQuery('#filer_input').filer({
            limit: 1,
            showThumbs: true,
            addMore: true,
            allowDuplicates: false,
            captions:{
                button: "Choisissez des fichiers",
                feedback: "Choisissez des fichiers à ajouter",
                feedback2: "fichiers choisis",
                drop: "Drop file here to Upload",
                removeConfirmation: "Supprimer ce fichier ?",
                errors: {
                    filesLimit: "Only {{fi-limit}} files are allowed to be uploaded.",
                    filesType: "Only Images are allowed to be uploaded.",
                    filesSize: "{{fi-name}} is too large! Please upload file up to {{fi-fileMaxSize}} MB.",
                    filesSizeAll: "Files you've choosed are too large! Please upload files up to {{fi-maxSize}} MB.",
                    folderUpload: "You are not allowed to upload folders."
                }
            },
            changeInput: '<a class="choose-btn">Browse Files</a>',
            theme: "dragdropbox",
            templates: {
                box: '<ul class="jFiler-items-list jFiler-items-grid"></ul>',
                item: '<li class="jFiler-item">\
                            <div class="jFiler-item-container">\
                                <div class="jFiler-item-inner">\
                                    <div class="jFiler-item-thumb">\
                                        <div class="jFiler-item-status"></div>\
                                        <div class="jFiler-item-thumb-overlay">\
                                            <div class="jFiler-item-info">\
                                                <div style="display:table-cell;vertical-align: middle;">\
                                                    <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name}}</b></span>\
                                                    <span class="jFiler-item-others">{{fi-size2}}</span>\
                                                </div>\
                                            </div>\
                                        </div>\
                                        {{fi-image}}\
                                    </div>\
                                    <div class="jFiler-item-assets jFiler-row">\
                                        <ul class="list-inline pull-left">\
                                            <li>{{fi-progressBar}}</li>\
                                        </ul>\
                                        <ul class="list-inline pull-right">\
                                            <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                        </ul>\
                                    </div>\
                                </div>\
                            </div>\
                        </li>',
                itemAppend: '<li class="jFiler-item">\
                                <div class="jFiler-item-container">\
                                    <div class="jFiler-item-inner">\
                                        <div class="jFiler-item-thumb">\
                                            <div class="jFiler-item-status"></div>\
                                            <div class="jFiler-item-thumb-overlay">\
                                                <div class="jFiler-item-info">\
                                                    <div style="display:table-cell;vertical-align: middle;">\
                                                        <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name}}</b></span>\
                                                        <span class="jFiler-item-others">{{fi-size2}}</span>\
                                                    </div>\
                                                </div>\
                                            </div>\
                                            {{fi-image}}\
                                        </div>\
                                        <div class="jFiler-item-assets jFiler-row">\
                                            <ul class="list-inline pull-left">\
                                                <li><span class="jFiler-item-others">{{fi-icon}}</span></li>\
                                            </ul>\
                                            <ul class="list-inline pull-right">\
                                                <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                            </ul>\
                                        </div>\
                                    </div>\
                                </div>\
                            </li>',
                progressBar: '<div class="bar"></div>',
                itemAppendToEnd: false,
                canvasImage: true,
                removeConfirmation: true,
                _selectors: {
                    list: '.jFiler-items-list',
                    item: '.jFiler-item',
                    progressBar: '.bar',
                    remove: '.jFiler-item-trash-action'
                }
            }
        });
    }
});
