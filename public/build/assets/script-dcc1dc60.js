let i="http://proyecto-laravel.test/";window.addEventListener("DOMContentLoaded",function(){if(document.querySelector('[name="search"]')&&document.getElementById("search")&&document.getElementById("search").addEventListener("submit",function(l){l.preventDefault();let a=document.querySelector('[name="search"]').value;window.location.href=i+"profile/members/"+a}),document.querySelectorAll(".like-btn")){let l=document.querySelectorAll(".like-btn");const a=(n,r)=>{fetch(i+"like/save/"+n).then(function(e){return e.json()}).then(function(){fetch(i+"image/likecount/"+n).then(function(e){return e.json()}).then(function(e){if(Number(e.count)>=0&&document.querySelector(`[data-id="${r}"] > span`))if(document.querySelector(`[data-id="${r}"] > span`).textContent=e.count,Array(e.users)&&e.users.length>0){let t="";e.users.forEach(d=>{t+=`
                                            <li class="d-flex align-items-center gap-1 mb-2 border-bottom pb-1">
                                                <div style="background-image: url('`,d.image?t+=`${i}profile/avatar/${d.image}`:t+=`${i}img/default-avatar.jpg`,t+=`'); background-repeat: no-repeat; background-size: cover; background-position: center; width: 30px; height: 30px; border-radius: 100%;"></div>
                                                    <p>${d.name} ${d.surname}</p>
                                                </li>`}),document.querySelector(`[data-id="${r}"] > div > ul`)?document.querySelector(`[data-id="${r}"] > div > ul`).innerHTML=t:(t=`<ul class="d-none rounded text-dark py-2 px-4">
                                                ${t}
                                                </ul
                                                `,document.querySelector(`[data-id="${r}"] > div`).innerHTML=t)}else e.users.length==0&&document.querySelector(`[data-id="${r}"] > div > ul`).remove()})})};l.forEach(n=>{n.addEventListener("click",function(r){let e=r.target.id,t=r.target.nextElementSibling.dataset.id;n.classList.contains("btn-liked")?(n.setAttribute("src",i+"img/light-heart.png"),n.classList.remove("btn-liked"),a(e,t)):(n.setAttribute("src",i+"img/red-heart.png"),n.classList.add("btn-liked"),a(e,t))})})}});