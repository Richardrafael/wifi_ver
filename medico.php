<!DOCTYPE html>



<?php
session_start();
$_SESSION['id'] = $_GET['id'];          //user's mac address
$_SESSION['ap'] = $_GET['ap'];          // user ap

header('Content-type: text/html; charset=utf-8');
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="https://www.santacasasjc.com.br/wp-content/uploads/2018/06/cropped-favicon-ht-32x32.png">
  <link rel="stylesheet" href="css/fontawesomee/css/all.min.css">
  <link rel="stylesheet" href="estilos/forms.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <title>Wifi</title>
</head>

<body>
  <?php include('components/header.php'); ?>
  <div class="close" id="closeDiv">
    <i style="cursor: pointer;" class="fas fa-times fa-2x" id="closeBtn">
    </i>
  </div>
  <div class="termo" id="termo">
    <?php include('components/termo.php'); ?>
  </div>
  <div class="termo-over" id="termo-over">
  </div>
  <div class="container">
    <div class="form" id="form">
      <h1 class="titulo">Médico</h1>
      <?php include('components/noscript.php'); ?>
      <form method="POST" action="authorized_med_func.php">
        <input type="hidden" name="tipo1" value="me">
        <div>
          <i class="fa-solid fa-address-card"></i><input type="text" name="crm" id="crm" data-js="crm" placeholder="CRM" required>
        </div>
        <div id='container-loading' style="width: 100%; justify-content: center; align-items: center; display: flex ;">
          <img style="height: 5rem;" src="image/tube-spinner.svg" alt="">
        </div>
        <div style="width: 100%;" id="input_disable">
          <div>
            <i class="fa-solid fa-user"></i> <input type="text" name="nome" name="nome" id="nome" data-js="nome" placeholder="Nome Completo" required disabled>
          </div>
          <div>
            <i class="fa-regular fa-credit-card"></i> <input type="text" name="cpf" id="cpf" data-js="cpf" placeholder="CPF" required disabled>
          </div>
        </div>
        <div>
          <p><input type="checkbox" name="" id="" required> Aceito os <span class="termos-btn" id="termos-btn">Termos e Condições de uso</span></p>
        </div>
        <button disabled name="submit" class="btn" type="submit" id="btn">Logar</button>
      </form>
      <p></p>
    </div>
  </div>
  <script>
    const masks = {
      cpf(value) {
        return value
          .replace(/\D/g, '')
          .replace(/(\d{3})(\d)/, '$1.$2')
          .replace(/(\d{3})(\d)/, '$1.$2')
          .replace(/(\d{3})(\d{1,2})/, '$1-$2')
          .replace(/(-\d{2})\d+?$/, '$1')
      },
      nome(value) {
        value = value.replace(/\d/g, '');
        value = value.replace(/[^\w\sÀ-ú]/g, '');
        value = value.toLowerCase().replace(/(?:^|\s)\S/g, function(a) {
          return a.toUpperCase();
        });
        return value;
      },
      crm(value) {
        value = value.slice(0, 8);
        return value;
      }
    }

    document.querySelectorAll('input').forEach(($input) => {
      const field = $input.dataset.js
      $input.addEventListener('input', (e) => {
        e.target.value = masks[field](e.target.value)
      }, false)
    })

    const crm = document.getElementById('crm')
    let timeoutId;
    const loadingIndicator = document.getElementById('container-loading');
    const input_disable = document.getElementById('input_disable')
    input_disable.style.display = 'none'
    loadingIndicator.style.display = 'none';

    document.getElementById('crm').addEventListener('input', function() {
      clearTimeout(timeoutId);
      timeoutId = setTimeout(() => {
        if (crm.value.length === 5 || crm.value.length === 6 || crm.value.length === 8) {
          const valorcrm = crm.value;
          const ap = '<?php echo $_GET["ap"]; ?>';
          const id = '<?php echo $_GET["id"]; ?>';
          loadingIndicator.style.display = 'block';
          const xhr = new XMLHttpRequest();
          xhr.open('POST', 'verificar_matricula.php', true);
          xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          xhr.onreadystatechange = function() {
            loadingIndicator.style.display = 'none';
            if (xhr.readyState === 4 && xhr.status === 200) {
              const response = JSON.parse(xhr.responseText);
              if (response.success) {
                // window.location.href = `authorized_med_func.php?id=${id}&ap=${ap}&mmac=logado&tipo=me&crm=${valorcrm}`;
                const form = document.createElement('form');
                form.method = 'post';
                form.action = 'authorized_med_func.php';
                form.style.display = 'none';

                const inputId = document.createElement('input');
                inputId.type = 'hidden';
                inputId.name = 'id';
                inputId.value = id;
                form.appendChild(inputId);

                const inputAp = document.createElement('input');
                inputAp.type = 'hidden';
                inputAp.name = 'ap';
                inputAp.value = ap;
                form.appendChild(inputAp);

                const inputMmac = document.createElement('input');
                inputMmac.type = 'hidden';
                inputMmac.name = 'mmac';
                inputMmac.value = 'logado';
                form.appendChild(inputMmac);

                const inputTipo = document.createElement('input');
                inputTipo.type = 'hidden';
                inputTipo.name = 'tipo';
                inputTipo.value = 'me';
                form.appendChild(inputTipo);

                const inputCrm = document.createElement('input');
                inputCrm.type = 'hidden';
                inputCrm.name = 'crm';
                inputCrm.value = valorcrm;
                form.appendChild(inputCrm);

                document.body.appendChild(form);
                form.submit();
              } else {
                input_disable.style.display = 'block'
                document.getElementById('nome').disabled = false;
                document.getElementById('cpf').disabled = false;
                document.getElementById("btn").disabled = false;
              }
            }

          };
          xhr.send('crm=' + encodeURIComponent(valorcrm) + '&id=' + encodeURIComponent(id) + '&fu=' + encodeURIComponent('AA'));
        }
      }, 1000);
    });

    crm.addEventListener('input', () => {
      if (!validarcrm(crm.value)) {
        crm.setCustomValidity("crm inv�lido");
      } else {
        crm.setCustomValidity("");
      }
    });

    function validarcrm(crm) {
      crm = crm.replace(/\s/g, '');
      crm = crm.replace(/[-/]/g, '');
      return /^[0-9A-Za-z]{5,8}$/.test(crm);
    }

    const cpf = document.getElementById('cpf');
    cpf.addEventListener('input', () => {
      let strCPF = cpf.value.replace('.', '').replace('.', '').replace('-', '');
      if (validarCPF(strCPF) === false) {
        cpf.setCustomValidity("Preencha um CPF v�lido");
      } else {
        cpf.setCustomValidity("");
      }
    })

    const nome = document.getElementById('nome')

    nome.addEventListener('input', () => {
      let nomevalue = nome.value
      if (VerificaNome(nomevalue) === false) {
        nome.setCustomValidity("Nome precisa ser Completo");
      } else {
        nome.setCustomValidity("");
      }
    })

    function VerificaNome(nome) {
      nome = nome.trim();
      if (nome.split(' ').length < 2) {
        return false;
      }
      const termos = nome.split(' ');
      for (let termo of termos) {
        if (!/^[A-ZÀ-Ú]/.test(termo)) {
          return false;
        }
      }
      return true;
    }

    function validarCPF(cpf) {
      cpf = cpf.replace(/[^\d]+/g, '');
      if (cpf == '') return false;
      // Elimina CPFs inv�lidos conhecidos	
      if (cpf.length != 11 ||
        cpf == "00000000000" ||
        cpf == "11111111111" ||
        cpf == "22222222222" ||
        cpf == "33333333333" ||
        cpf == "44444444444" ||
        cpf == "55555555555" ||
        cpf == "66666666666" ||
        cpf == "77777777777" ||
        cpf == "88888888888" ||
        cpf == "99999999999")
        return false;
      // Valida 1o digito	
      add = 0;
      for (i = 0; i < 9; i++)
        add += parseInt(cpf.charAt(i)) * (10 - i);
      rev = 11 - (add % 11);
      if (rev == 10 || rev == 11)
        rev = 0;
      if (rev != parseInt(cpf.charAt(9)))
        return false;
      // Valida 2o digito	
      add = 0;
      for (i = 0; i < 10; i++)
        add += parseInt(cpf.charAt(i)) * (11 - i);
      rev = 11 - (add % 11);
      if (rev == 10 || rev == 11)
        rev = 0;
      if (rev != parseInt(cpf.charAt(10)))
        return false;
      return true;
    }

    const form = document.getElementById('form');
    const btn = document.getElementById('btn');
    const loading = document.getElementById('loading');
    const termosBtn = document.getElementById('termos-btn');
    const termo = document.getElementById('termo');
    const overlay = document.getElementById('termo-over');
    const closeDiv = document.getElementById('closeDiv');
    const closeBtn = document.getElementById('closeBtn');

    termosBtn.addEventListener('click', () => {
      termo.style.display = 'block';
      overlay.style.display = 'block';
      closeDiv.style.display = 'block';
    })

    overlay.addEventListener('click', () => {
      termo.style.display = 'none';
      overlay.style.display = 'none';
      closeBtn.style.display = 'none';
    })

    closeBtn.addEventListener('click', () => {
      termo.style.display = 'none';
      overlay.style.display = 'none';
      closeBtn.style.display = 'none';
    })
  </script>

</body>

</html>