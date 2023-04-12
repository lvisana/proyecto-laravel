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
                            if (Number(json.count) >= 0 && document.querySelector(`[data-id="${count}"]`)) {
                                document.querySelector(`[data-id="${count}"]`).textContent = json.count
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
