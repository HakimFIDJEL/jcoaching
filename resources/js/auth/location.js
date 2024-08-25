// $(document).ready(function()
// {
//     var searchResults = $('#search-results');

//     var addressInput = $('#address');
//     var cityInput = $('#city');
//     var postalCodeInput = $('#postal_code');
//     var countryInput = $('#country');

//     var timer = null;

  

//     $(document).on('keyup', '#address', function(){
//         var location = $(this).val();

//         if(location.length > 2)
//         {
//             clearTimeout(timer);

//             // Show the search results
//             searchResults.addClass('loading');
//             searchResults.show();
            
//             timer = setTimeout(function()
//             {
//                 searchResults.removeClass('loading');
//                 searchResults.children().not('.loading').remove();

//                 // Append the suggestions
                

//                 // Exemple

//                 // filteredSuggestions.forEach(suggestion => {
//                 //     searchResults.append('<a href="javascript:void(0);" class="dropdown-item">' + suggestion + '</a>');
//                 // });
                
//                 // if(filteredSuggestions.length === 0)
//                 // {
//                 //     searchResults.append('<li class="dropdown-item">Aucun résultat trouvé</li>');
//                 // }
                    

//             }, 500);
//         }
//         else 
//         {
//             searchResults.children().not('.loading').remove();
//             searchResults.hide();

//         }
//     });



// });