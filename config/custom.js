//Containers
async function loadContainers(val) {
  if (val.length >= 1) {
    const dados = await fetch('../config/autocompleteContainer.php?cd=' + val)
    const resposta = await dados.json()

    var html = "<ul class='list-group position-fixed'>"

    if (resposta['erro']) {
      html +=
        "<li class='list-group-item disabled'>" + resposta['msg'] + '</li>'
    } else {
      for (i = 0; i < resposta['dados'].length; i++) {
        html +=
          "<li class='list-group-item list-group-item-action' onclick='get_container(" +
          JSON.stringify(resposta['dados'][i].cd) +
          ',' +
          JSON.stringify(resposta['dados'][i].tipo) +
          ',' +
          JSON.stringify(resposta['dados'][i].categoria) +
          ")'>" +
          resposta['dados'][i].cd +
          '</li>'
      }
    }

    html += '</ul>'

    document.getElementById('resultado_pesquisaContainer').innerHTML = html
  }
}

function get_container(cd, tipo) {
  const cd_field = document.getElementById('cd')
  const type_field = document.getElementById('type')

  if (cd_field != null) {
    cd_field.value = cd
  }

  if (type_field != null) {
    type_field.value = tipo
    type_field.innerHTML = tipo
  }
}

function fecharContainer() {
  const fecharContainer = document.getElementById('cd')
  document.addEventListener('click', function (event) {
    const validar_clique = fecharContainer.contains(event.target)
    if (!validar_clique) {
      document.getElementById('resultado_pesquisaContainer').innerHTML = ''
    }
  })
}

//Clientes
async function loadClients(val) {
  if (val.length >= 1) {
    const dados = await fetch('../config/autocompleteClient.php?cd=' + val)
    const resposta = await dados.json()
    console.log(resposta)

    var html = "<ul class='list-group position-fixed'>"

    if (resposta['erro']) {
      html +=
        "<li class='list-group-item disabled'>" + resposta['msg'] + '</li>'
    } else {
      for (i = 0; i < resposta['dados'].length; i++) {
        html +=
          "<li class='list-group-item list-group-item-action' onclick='get_client(" +
          JSON.stringify(resposta['dados'][i].cd) +
          ")'>" +
          resposta['dados'][i].cd +
          '</li>'
      }
    }

    html += '</ul>'

    document.getElementById('resultado_pesquisaClient').innerHTML = html
  }
}

function get_client(cd) {
  const cd_field = document.getElementById('cd')
  if (cd_field != null) {
    cd_field.value = cd
  }
}

function fecharClient() {
  const fecharClient = document.getElementById('cd')
  document.addEventListener('click', function (event) {
    const validar_clique = fecharClient.contains(event.target)
    if (!validar_clique) {
      document.getElementById('resultado_pesquisaClient').innerHTML = ''
    }
  })
}
