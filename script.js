/**
 * Created by Jan on 09.02.2017.
 */
$(document).ready(function(){
    var schere = $('#scissors');
    var stein = $('#rock');
    var papier = $('#paper');
    var echse = $('#lizard');
    var spock = $('#spock');

    schere.click(function (e) {
        e.preventDefault();
        console.log('schere');
    });

    stein.click(function (e) {
        e.preventDefault();
        console.log('stein');
    });

    papier.click(function (e) {
        e.preventDefault();
        console.log('papier');
    });

    echse.click(function (e) {
        e.preventDefault();
        console.log('echse');
    });

    spock.click(function (e) {
        e.preventDefault();
        console.log('spock');
    });
});