(() => {
  document.addEventListener('DOMContentLoaded', function () {
    let clientId = 'g52o5obmxfx9fjsr6w33tfepar7vc5'
    let game = 'League%20of%20Legends'
    let limit = 20

    let request = new XMLHttpRequest()

    request.open('GET', `https://api.twitch.tv/kraken/streams/?game=${game}&limit=${limit}&client_id=${clientId}`, true)

    request.onload = function () {
      if (request.status >= 200 && request.status < 400) {
        let response = JSON.parse(request.responseText)
        for (let i = 0; i < response.streams.length; i++) {
          let stream = document.createElement('div')
          stream.className = 'twitch__content__cards'
          stream.innerHTML = `
      <div class="twitch__content__card" onclick="location.href='${response.streams[i].channel.url}'">
        <div class="twitch__content__card__video">
            <img class="video--placeholder">
            <img class="video--img" src="${response.streams[i].preview.medium}" alt="video" onload="this.style.opacity=1">
        </div>

        <div class="twitch__content__card__info">
          <div class="twitch__content__card__info__avatar">
            <img class="avatar--img" src="${response.streams[i].channel.logo}" alt="avatar" onload="this.style.opacity=1">
          </div>
        <div class="twitch__content__card__info__txt">
          <p class="twitch__content__card__info__channel">
          ${response.streams[i].channel.status}
          </p>
          <p class="twitch__content__card__info__creator">
          ${response.streams[i].channel.display_name}
          </p>
        </div>
        </div>
      </div>`
          let content = document.getElementById('content')
          if (content !== null) content.appendChild(stream)
        } // end-for
      } // end-if
    } // end-onload
    request.send()
  })
})()
