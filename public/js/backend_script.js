$(document).ready(function () {

    function doSmth(a) {
        for (var q = 1, i = 1; q < a.length; ++q) {
            if (a[q] !== a[q - 1]) {
                a[i++] = a[q];
            }
        }

        a.length = i;
        return a;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#end_game').click(function (event) {
        event.preventDefault();

        let array_data = [];
        let team_data = [];
        // $('[request=true]').find("input").each(function () {
        //   console.log(this.value);
        // });
        $('.final_team_id').each(function (index) {

            data = {};
            data.team_id = $(this).attr('final_team_id');

            array_data.push(data);

        });

        let jsonData = JSON.stringify(array_data);

        // console.log(jsonData);
        // console.log($('#game_id').attr('game_id'));

        $.ajax({
            type: 'POST',
            url: '/ajaxRequestFinalizeGame',
            data: {
                request_data: jsonData,
                game_id: $('#game_id').attr('game_id')
            },
            success: function (data) {
              console.log(data.success);
                alert(data.success);
                location.reload();
            }
        });
    });

    $('#update_game').click(function (event) {
        event.preventDefault();

        let array_data = [];
        let team_data = [];
        // $('[request=true]').find("input").each(function () {
        //   console.log(this.value);
        // });
        $('[request=true]').each(function (index) {

            data = {};
            data.team_id = $(this).find("input").attr('team_id');
            data.round_id = $(this).find("input").attr('round_id');
            data.score = $(this).find("input").val();

            array_data.push(data);

        });

        let jsonData = JSON.stringify(array_data);

        // console.log(jsonData);
        // console.log($('#game_id').attr('game_id'));

        $.ajax({
            type: 'POST',
            url: '/ajaxRequestUpdateGame',
            data: {
                request_data: jsonData,
                game_id: $('#game_id').attr('game_id')
            },
            success: function (data) {
                // console.log(data.success);
                location.reload();
            }
        });
    });
});
