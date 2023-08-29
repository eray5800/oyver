const likeButtons = document.querySelectorAll('.likebutton');
const likeIcons = document.querySelectorAll('.fa-heart');
const likeCounts = document.querySelectorAll('#likeCount');
const token = document.querySelector('input[name="_token"]').getAttribute('value');

likeButtons.forEach((likeButton, i) => {
  const poolId = likeButton.getAttribute('data-pool-id');
  const commentId = likeButton.getAttribute('data-comment-id');
  const userID = likeButton.getAttribute('data-user-id');


  likeButton.addEventListener('click', function () {
    const liked = likeButton.classList.contains('liked');
    if (liked) {
      unlikePost();
      likeButton.classList.remove('liked');
      likeIcons[i].style.color = "white"
    } else {
      likePost();
      likeButton.classList.add('liked');
      likeIcons[i].style.color = "#dc3545"
    }
  });

  function likePost() {
    const data = {
      like: true,
      user_id: userID,
      pool_id: poolId,
      comment_id: commentId
    };

    fetch('/comment/likeorunlike', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token
      },
      body: JSON.stringify(data)
    })
      .then(response => response.json())
      .then(response => {
        if (response.success) {
          likeCounts[i].textContent = response.likes + ' Beğeni';
        }
      })
      .catch(error => console.error(error));
  }

  function unlikePost() {
    const data = {
      like: false,
      user_id: userID,
      pool_id: poolId,
      comment_id: commentId
    };

    fetch('/comment/likeorunlike', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token
      },
      body: JSON.stringify(data)
    })
      .then(response => response.json())
      .then(response => {
        if (response.success) {
          likeCounts[i].textContent = response.likes + ' Beğeni';
        }
      })
      .catch(error => console.error(error));
  }
});