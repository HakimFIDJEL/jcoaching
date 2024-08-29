 // Initialiser le compteur avec le nombre de spécificités préchargées
 let featureCount = document.querySelectorAll('.feature-row').length;

 // Fonction pour supprimer une spécificité
 function removeFeature(event) {
     event.target.closest('.feature-row').remove();
 }
 
 // Ajouter un événement de suppression pour chaque spécificité préchargée
 document.querySelectorAll('.remove-feature').forEach(button => {
     button.addEventListener('click', removeFeature);
 });
 
 // Ajouter dynamiquement une spécificité
 document.getElementById('add-feature').addEventListener('click', function() {
     featureCount++;
 
     const featureRow = document.createElement('div');
     featureRow.className = 'row mb-3 feature-row';
     featureRow.dataset.featureId = featureCount;
     featureRow.innerHTML = `
         <div class="col">
             <div>
                 <label for="feature_${featureCount}" class="form-label">Spécificité ${featureCount}</label>
                 <input 
                     type="text" 
                     class="form-control" 
                     id="feature_${featureCount}" 
                     name="features[]" 
                     placeholder="Entrez la spécificité ${featureCount}" 
                     required
                 >
             </div>
         </div>
         <div class="col-1 d-flex align-items-end justify-content-end">
             <a href="javascript:void(0);" title="Supprimer la spécificité" class="btn btn-outline-danger mt-2 remove-feature">
                 <i class="fas fa-trash"></i>
             </a>
         </div>
     `;
 
     document.getElementById('features-container').appendChild(featureRow);
 
     // Ajouter l'événement pour supprimer la spécificité
     featureRow.querySelector('.remove-feature').addEventListener('click', removeFeature);
 });