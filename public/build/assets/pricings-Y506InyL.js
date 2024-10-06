let t=document.querySelectorAll(".feature-row").length;function r(e){e.target.closest(".feature-row").remove()}document.querySelectorAll(".remove-feature").forEach(e=>{e.addEventListener("click",r)});document.getElementById("add-feature").addEventListener("click",function(){t++;const e=document.createElement("div");e.className="row mb-3 feature-row",e.dataset.featureId=t,e.innerHTML=`
         <div class="col">
             <div>
                 <label for="feature_${t}" class="form-label">Spécificité ${t}</label>
                 <input 
                     type="text" 
                     class="form-control" 
                     id="feature_${t}" 
                     name="features[]" 
                     placeholder="Entrez la spécificité ${t}" 
                     required
                 >
             </div>
         </div>
         <div class="col-1 d-flex align-items-end justify-content-end">
             <a href="javascript:void(0);" title="Supprimer la spécificité" class="btn btn-outline-danger mt-2 remove-feature">
                 <i class="fas fa-trash"></i>
             </a>
         </div>
     `,document.getElementById("features-container").appendChild(e),e.querySelector(".remove-feature").addEventListener("click",r)});
