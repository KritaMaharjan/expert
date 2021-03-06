$('.expiry_date').datepicker({format: 'yyyy-mm-dd', startDate: new Date()});

$(document).ready(function () {

    // Car functions
    $('input[type=radio][name=cars]').change(function () {
        if (this.value == 1) {
            $('.car-details').fadeIn('slow');
        }
        else if (this.value == 0) {
            $('.car-details').fadeOut('slow');
        }
    });

    $("input[type=radio][name='car_loan[]']").change(function () {
        if (this.value == 1) {
            $('.car-loan-details').fadeIn('slow');
        }
        else if (this.value == 0) {
            $('.car-loan-details').fadeOut('slow');

            $(".car-details").on('change', "input[type='radio'][class='car_loan']", function () {
                if (this.value == 1) {
                    $(this).closest('.new-car').find('.car-loan-details').fadeIn('slow');
                    $(this).closest('.new-car').find('.balance').fadeIn('slow');
                }
                else if (this.value == 0) {
                    $(this).closest('.new-car').find('.car-loan-details').fadeOut('slow');
                    $(this).closest('.new-car').find('.balance').fadeOut('slow');
                }
            });
        }
    });

    $('.add-car').click(function (e) {
        e.preventDefault();
        var newCar = '<div class="new-car">' + $('.new-car').last().html() + '</div>';
        var numCars_before_insert = $('.car-details .new-car').length;
        $nc = $(newCar);
        $nc.find('.car_loan').removeAttr('name').attr('name', 'car_loan[' + numCars_before_insert + ']');
        $nc.find('.car_to_be_cleared').removeAttr('name').attr('name', 'to_be_cleared[' + numCars_before_insert + ']');
        //console.log($nc.find('.car_loan'));
        var newCarElement = $nc.insertAfter($('.new-car').last());
        var numCars = $('.car-details .new-car').length;
        newCarElement.find('.car-num').html(numCars);

        if (numCars == 10) {
            $('.add-car-div').hide();
        }
    });

    $(document).on('click', '.remove-car', function (e) {
        //$('.remove-car').click(function(e) {
        e.preventDefault();
        var numCars = $('.car-details .new-car').length;
        if (numCars == 1) {
            $('input[type=radio][name=cars][value = "0"]').prop('checked', true);
            $('.car-details').fadeOut('slow');
            return false;
        }

        if (!confirm('Are you sure you want to remove this?')) return false;

        var parentDiv = $(this).parent().parent().parent();
        parentDiv.hide('slow', function () {
            $(this).remove();
            $(".new-car").each(function (index) {
                $(this).find('.car-num').html(index + 1);
            });
        });
        if (numCars == 10) $('.add-car-div').show();
    });

    // Bank accounts functions
    $('input[type=radio][name=banks]').change(function () {
        if (this.value == 1) {
            $('.bank-details').fadeIn('slow');
        }
        else if (this.value == 0) {
            $('.bank-details').fadeOut('slow');
        }
    });

    $('.add-bank').click(function (e) {
        e.preventDefault();
        var newBank = '<div class="new-bank">' + $('.new-bank').last().html() + '</div>';
        var newBankElement = $(newBank).insertAfter($('.new-bank').last());
        var numBanks = $('.bank-details .new-bank').length;
        newBankElement.find('.bank-num').html(numBanks);

        if (numBanks == 10) {
            $('.add-bank-div').hide();
        }
    });

    $(document).on('click', '.remove-bank', function (e) {
        //$('.remove-bank').click(function(e) {
        e.preventDefault();
        var numBanks = $('.bank-details .new-bank').length;
        if (numBanks == 1) {
            $('input[type=radio][name=banks][value = "0"]').prop('checked', true);
            $('.bank-details').fadeOut('slow');
            return false;
        }

        if (!confirm('Are you sure you want to remove this?')) return false;

        var parentDiv = $(this).parent().parent().parent();
        parentDiv.hide('slow', function () {
            $(this).remove();
            $(".new-bank").each(function (index) {
                $(this).find('.bank-num').html(index + 1);
            });
        });
        if (numBanks == 10) $('.add-bank-div').show();
    });

    // Other asset functions
    $('input[type=radio][name=assets]').change(function () {
        if (this.value == 1) {
            $('.asset-details').fadeIn('slow');
        }
        else if (this.value == 0) {
            $('.asset-details').fadeOut('slow');
        }
    });

    $('.add-asset').click(function (e) {
        e.preventDefault();
        var newAsset = '<div class="new-asset">' + $('.new-asset').last().html() + '</div>';
        var newAssetElement = $(newAsset).insertAfter($('.new-asset').last());
        var numAssets = $('.asset-details .new-asset').length;
        newAssetElement.find('.asset-num').html(numAssets);

        if (numAssets == 10) {
            $('.add-asset-div').hide();
        }
    });

    $(document).on('click', '.remove-asset', function (e) {
        e.preventDefault();
        var numAssets = $('.asset-details .new-asset').length;
        if (numAssets == 1) {
            $('input[type=radio][name=assets][value = "0"]').prop('checked', true);
            $('.asset-details').fadeOut('slow');
            return false;
        }

        if (!confirm('Are you sure you want to remove this?')) return false;

        var parentDiv = $(this).parent().parent().parent();
        parentDiv.hide('slow', function () {
            $(this).remove();
            $(".new-asset").each(function (index) {
                $(this).find('.asset-num').html(index + 1);
            });
        });
        if (numAssets == 10) $('.add-asset-div').show();
    });

    // Other card functions
    $('input[type=radio][name=cards]').change(function () {
        if (this.value == 1) {
            $('.card-details').fadeIn('slow');
        }
        else if (this.value == 0) {
            $('.card-details').fadeOut('slow');
        }
    });

    $('.add-card').click(function (e) {
        e.preventDefault();
        var newCard = '<div class="new-card">' + $('.new-card').last().html() + '</div>';
        var newCardElement = $(newCard).insertAfter($('.new-card').last());
        var numCards = $('.card-details .new-card').length;
        newCardElement.find('.card-num').html(numCards);

        if (numCards == 10) {
            $('.add-card-div').hide();
        }
    });

    $(".card-details").on('change', ".card_types .card_type", function (e) {
        e.preventDefault();
        console.log($(this).closest('.new-card').find('.card_type option:selected').val());
        if ($(this).closest('.new-card').find('.card_type option:selected').val() == "Other") {
            $(this).closest('.new-card').find('.other-name').show();
        } else {
            $(this).closest('.new-card').find('.other-name').hide();
        }
    });


    $('.add-card').click(function (e) {
        e.preventDefault();
        var numCards_before_insert = $('.card-details .new-card').length;
        var newCard = '<div class="new-card">' + $('.new-card').last().html() + '</div>';

        $nCard = $(newCard);
        $nCard.find('.card_type').removeAttr('name').attr('name', 'card_type[' + numCards_before_insert + ']');
        $nCard.find('.others_text').removeAttr('name').attr('name', 'others[' + numCards_before_insert + ']');
        $nCard.find('.card_to_be_cleared').removeAttr('name').attr('name', 'card_to_be_cleared[' + numCards_before_insert + ']');

        var newCardElement = $nCard.insertAfter($('.new-card').last());
        var numCards = $('.card-details .new-card').length;
        newCardElement.find('.card-num').html(numCards);

        if (numCards == 10) {
            $('.add-card-div').hide();
        }
    });

    $(document).on('click', '.remove-card', function (e) {
        e.preventDefault();
        var numCards = $('.card-details .new-card').length;
        if (numCards == 1) {
            $('input[type=radio][name=cards][value = "0"]').prop('checked', true);
            $('.card-details').fadeOut('slow');
            return false;
        }

        if (!confirm('Are you sure you want to remove this?')) return false;

        var parentDiv = $(this).parent().parent().parent();
        parentDiv.hide('slow', function () {
            $(this).remove();
            $(".new-card").each(function (index) {
                $(this).find('.card-num').html(index + 1);
            });
        });
        if (numCards == 10) $('.add-card-div').show();
    });

    // Other other-income functions
    $('input[type=radio][name=other-incomes]').change(function () {
        if (this.value == 1) {
            $('.other-income-details').fadeIn('slow');
        }
        else if (this.value == 0) {
            $('.other-income-details').fadeOut('slow');
        }
    });

    $('.add-other-income').click(function (e) {
        e.preventDefault();
        var newIncome = '<div class="new-other-income">' + $('.new-other-income').last().html() + '</div>';
        var newIncomeElement = $(newIncome).insertAfter($('.new-other-income').last());
        var numIncomes = $('.other-income-details .new-other-income').length;
        newIncomeElement.find('.other-income-num').html(numIncomes);

        if (numIncomes == 10) {
            $('.add-other-income-div').hide();
        }
    });

    $(document).on('click', '.remove-other-income', function (e) {
        //$('.remove-other-income').click(function(e) {
        e.preventDefault();
        var numIncomes = $('.other-income-details .new-other-income').length;
        if (numIncomes == 1) {
            $('input[type=radio][name=other-incomes][value = "0"]').prop('checked', true);
            $('.other-income-details').fadeOut('slow');
            return false;
        }

        if (!confirm('Are you sure you want to remove this?')) return false;

        var parentDiv = $(this).parent().parent().parent();
        parentDiv.hide('slow', function () {
            $(this).remove();
            $(".new-other-income").each(function (index) {
                $(this).find('.other-income-num').html(index + 1);
            });
        });
        if (numIncomes == 10) $('.add-other-income-div').show();
    });
});
