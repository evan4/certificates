import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

$(function ($) {
  "use strict";

  const alertDanger = $('#alert-danger');
  const alertSuccess = $('#alert-success');


  // send certificate code for validation & activation
  $('#cert-activate').on('submit', function (e) {
    e.preventDefault();

    alertDanger.addClass('hidden').find('ul').empty();
    alertSuccess.addClass('hidden').find('p').text('');
    const ul = alertDanger.addClass('hidden').find('ul');

    $.ajax({
      url: '/activate-certificate',
      method: "POST",
      data: $(this).serializeArray(),
      dataType: 'json',
    })
      .done((res) => {
        console.log(res);

        if(res.success) {
          alertSuccess.removeClass('hidden')
          .text('Your certificate was activated!');
        }else{
          if(res.hasOwnProperty("responseJSON")){
            showErrors(res.responseJSON)
          }
        }
        
        $('#cert-activate')[0].reset();
      })
      .fail( (res) => {
        
        if(res.hasOwnProperty("responseJSON")){
          showErrors(res.responseJSON)
        }
          
      });
  });

  //total sum
  const total = $('#total');

  const amount = $('#amount');
  const plantation = $('#plantation-id');

  amount.on('change', function(){
    const amountVal = +amount.val();
    
    if(amountVal > 0){
      const treePrice = +plantation.find('option:selected').data('price');

      total.html('&euro;'+amountVal*treePrice);
    }
  });

  // change trees amount
  $('#btn-group-amount').on('click', 'button', function(e){
    const operation = $(this).data('operation');
    let amountVal = +amount.val();
    
    if(operation === 'minus'){
      if(amountVal > 1){
        amountVal--;
      }
      
    }else{
      amountVal++;
    }
    amount.val(amountVal)
    const treePrice = +plantation.find('option:selected').data('price');
    total.html('&euro;'+amountVal*treePrice);
  });

  const treePrice = +plantation.find('option:selected').data('price');
  const amountVal = +amount.val();
  total.html('&euro;'+amountVal*treePrice);

  $('#cert-create').on('submit', function(e){
    e.preventDefault();
    alertDanger.addClass('hidden').find('ul').empty();
    alertSuccess.addClass('hidden').find('p').text('');
    const ul = alertDanger.addClass('hidden').find('ul');

    const treePrice = +plantation.find('option:selected').data('price');
    const amountVal = +amount.val();
    const totalVal = amountVal*treePrice;
    let data = $(this).serializeArray();
    data.push({name: 'total', value: totalVal});

    $.ajax({
      url: '/store-certificate',
      method: "POST",
      data,
      dataType: 'json',
    })
      .done((res) => {
        console.log(res);

        if(res.success) {
          alertSuccess.removeClass('hidden')
          .text('You bought this certificate!');
        }else{
          if(res.hasOwnProperty("responseJSON")){
            showErrors(res.responseJSON)
          }
        }
        
        $('#cert-create')[0].reset();
      })
      .fail( (res) => {
        if(res.hasOwnProperty("responseJSON")){
          showErrors(res.responseJSON)
        }
          
      });
  });
});

function showErrors(responseJSON){
  const alertDanger = $('#alert-danger');
  const ul = alertDanger.find('ul');

  if(responseJSON.hasOwnProperty("msg")){
    ul.append(`<li>${responseJSON.msg}</li>`)
  }else if(responseJSON.hasOwnProperty("errors")){
    const {errors} = responseJSON
    for (const key in errors) {

      if (errors.hasOwnProperty.call(errors, key)) {
        const element = errors[key];
        element.forEach(messageError => {
          ul.append(`<li>${messageError}</li>`)
        })
      }
    }
  }
  alertDanger.removeClass('hidden')
}
