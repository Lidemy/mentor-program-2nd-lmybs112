(($) => {
  let getData = (callback) => {
    let clientId = 'g52o5obmxfx9fjsr6w33tfepar7vc5'
    let game = "League%20of%20Legends"
    let limit = 20
    $.ajax({
      url: `https://api.twitch.tv/kraken/streams/?game=${game}&limit=${limit}&client_id=${clientId}`,
      success: (response) => {
        console.log(response)
        callback(null, response)
      }
    })
  }

  getData((err, data) => {
    const {
      streams
    } = data;
    const $content = $('.twitch__content')
    for (let stream of streams) {
      $content.append(getCard(stream))
    }
  })

  let getCard = (data) => {
    return `
      <div class="twitch__content__card" onclick="location.href='${data.channel.url}'">

        <div class="twitch__content__card__video">
            <img class="video--placeholder">
            <img class="video--img" src="${data.preview.medium}" alt="video" onload="this.style.opacity=1">
        </div>

      <div class="twitch__content__card__info">
        <div class="twitch__content__card__info__avatar">
          <img class="avatar--img" src="${data.channel.logo}" alt="avatar" onload="this.style.opacity=1">
        </div>
        <div class="twitch__content__card__info__txt">
          <p class="twitch__content__card__info__channel">
          ${data.channel.status}
          </p>
          <p class="twitch__content__card__info__creator">
          ${data.channel.display_name}
          </p>

        </div>
      </div>
    </div>`
  }
})($)