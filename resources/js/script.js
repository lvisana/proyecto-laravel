let home = 'http://proyecto-laravel.test/'

window.addEventListener('DOMContentLoaded', function() {
    if (document.querySelectorAll('.like-btn')) {

        let btn = document.querySelectorAll('.like-btn');

        const saveLike = (id, count) =>{

            fetch(home+'like/save/'+id)
                .then(function(response) {
                    return response.json();
                })
                .then(function() {

                    fetch(home+'image/likecount/'+id)
                        .then(function(response) {
                            return response.json();
                        }).then(function(json) {
                            
                            if (Number(json.count) >= 0 && document.querySelector(`[data-id="${count}"] > span`)) {

                                document.querySelector(`[data-id="${count}"] > span`).textContent = json.count

                                if (Array(json.users) && json.users.length > 0) {

                                    let html = ``;

                                    json.users.forEach(el => {
                                        html += `
                                            <li class="d-flex align-items-center gap-1 mb-2 border-bottom pb-1">
                                                <div style="background-image: url('`

                                        if (el.image) {
                                            html += `${home}profile/avatar/${el.image}`
                                        } else {
                                            html += `${home}img/default-avatar.jpg`
                                        }

                                        html += `'); background-repeat: no-repeat; background-size: cover; background-position: center; width: 30px; height: 30px; border-radius: 100%;"></div>
                                                    <p>${el.name} ${el.surname}</p>
                                                </li>`
                                    })

                                    if (!document.querySelector(`[data-id="${count}"] > div > ul`)) {
                                        html = `<ul class="d-none rounded text-dark py-2 px-4">
                                                ${html}
                                                </ul
                                                `
                                        document.querySelector(`[data-id="${count}"] > div`).innerHTML = html
                                    } else {
                                        document.querySelector(`[data-id="${count}"] > div > ul`).innerHTML = html
                                    }

                                } else if (json.users.length == 0) {
                                    document.querySelector(`[data-id="${count}"] > div > ul`).remove()
                                }
                            }
                        })
                });
        }


        btn.forEach(el => {
            el.addEventListener('click', function(e) {

                let id = e.target.id
                let likeCount = e.target.nextElementSibling.dataset.id

                    if (el.classList.contains('btn-liked')) {

                        el.setAttribute('src', home+'img/light-heart.png');
                        el.classList.remove('btn-liked');
                        saveLike(id, likeCount);

                    } else {
                        el.setAttribute('src', home+'img/red-heart.png');
                        el.classList.add('btn-liked');
                        saveLike(id, likeCount);
                    }
                })
        })

    }

})
