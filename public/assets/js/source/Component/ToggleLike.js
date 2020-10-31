class ToggleLike
{

    _likeRepository;

    constructor(likeRepository) {
        this._likeRepository = likeRepository;
    }

    initialize() {
        console.log('ToggleLike initialized');
        let likeForms = document.querySelectorAll('.like-form');
        for (let likeForm of likeForms) {
            likeForm.addEventListener('submit', (event) => {this.handleLikeFormSubmit(event)});
        }
    }

    handleLikeFormSubmit(event) {
        event.preventDefault();
        const eventTarget = event.target;
        const answerId = eventTarget.dataset.answerId;

        const checkIcon = eventTarget.querySelector('.check-icon');
        const likeCounter = document.querySelector('.like-counter-' + answerId)

        this._likeRepository.toggleLike(answerId).then((response) => {
            // console.log(response);
            const likeStatus = response['likeStatus'];
            // console.log(likeStatus);
            if(likeStatus) {
                // console.log(likeStatus);
                this.addLikeDisplay(checkIcon, likeCounter)
            } else {
                // console.log(likeStatus);
                this.removeLikeDisplay(checkIcon, likeCounter)
            }

        })
    }

    addLikeDisplay(checkIcon, likeCounter) {
        // dynamically change counter value
        let LikeCounterValue = parseInt(likeCounter.innerHTML, 10);
        let newLikeCounterValue = LikeCounterValue+1;
        likeCounter.innerHTML = newLikeCounterValue;
        // dynamically change checkIcon color
        checkIcon.style.color = 'green';
        
    }

    removeLikeDisplay(checkIcon, likeCounter) {
        // dynamically change counter value
        let LikeCounterValue = parseInt(likeCounter.innerHTML, 10);
        let newLikeCounterValue = LikeCounterValue-1;
        likeCounter.innerHTML = newLikeCounterValue;
        // dynamically change checkIcon color
        checkIcon.style.color = '#AAAAAA';

    }

}