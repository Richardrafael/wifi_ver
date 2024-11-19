<?php
session_start();
$_SESSION['id'] = $_GET['id'];          //user's mac address
$_SESSION['ap'] = $_GET['ap'];          // user ap          
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/fontawesomee/css/all.min.css">
  <link rel="stylesheet" href="estilos/forms.css">
  <link rel="icon" type="image/x-icon" href="https://www.santacasasjc.com.br/wp-content/uploads/2018/06/cropped-favicon-ht-32x32.png">
  <title>Wifi</title>
</head>

<body>
  <?php include('components/header.php'); ?>
  <div class="close" id="closeDiv"><i class="fas fa-times fa-2x" style="cursor: pointer;" id="closeBtn"></i></div>
  <div class="termo" id="termo">
    <?php include('components/termo.php'); ?>
  </div>
  <div class="termo-over" id="termo-over">
  </div>
  <div class="container1">
    <div class="form" id="form">
      <h1 class="titulo">Paciente</h1>
      <?php include('components/noscript.php'); ?>
      <div class="container-options">
        <div>
          <input type="radio" name="tipo_paciente" id="paciente_com_atendimento" value="paciente_com_atendimento">
          <label for="paciente_com_atendimento">Paciente com nº de atendimento
          </label>
        </div>
        <div>
          <input type="radio" name="tipo_paciente" id="paciente_sem_atendimento" value="paciente_sem_atendimento">
          <label for="paciente_sem_atendimento">Paciente com a senha do totem
          </label>
        </div>
      </div>

      <div class="container-forms">
        <form id="form_com_atendimento" class="hidden" method="POST" action="authorized.php">
          <input type="hidden" name="tipo1" value="pc">
          <div>
            <i class="fa-solid fa-hospital"></i>
            <input type="text" name="numero_atend" id="numero_atend" data-js="numero_atend" placeholder="Numero Atendimento" required>
          </div>
          <div id='container-loading' style="width: 100%; justify-content: center; align-items: center; display: flex ;">
            <img style="height: 5rem;" src="image/tube-spinner.svg" alt="">
          </div>
          <div style="width: 100% ; display:none ; flex-direction: column;" id="error">
            <span style="font-size: 1rem; font-weight: 600; color:brown">Numero de Atendimento não encontrado</span>
            <span style="font-size: 0.9rem; font-weight: 600; color:brown">Tente Novamente</span>
          </div>
          <div style="width: 100%;" id="input_disable">
            <div>
              <input type="hidden" name="mmac" value="nologado">
            </div>
            <div>
              <i class="fa-regular fa-credit-card"></i> <input disabled type="text" name="cpf1" id="cpf1" data-js="cpf1" placeholder="CPF" required>
            </div>
            <div>
              <i class="fa-solid fa-calendar-days"></i> <input disabled type="text" placeholder="Data Nascimento" onfocus="this.type='date'" onblur="if (!this.value) this.type='text'" name="data_nasc" id="data_nasc" data-js="data_nasc" placeholder="Data de Nascimento" required>
            </div>
            <div>
              <i class="fas fa-envelope"></i> <input disabled type="email" name="email_1" id="email_1" data-js="email_1" placeholder="E-mail" required>
            </div>
            <div>
            </div>
          </div>
          <p><input type="checkbox" name="" id="" required> Aceito os <span class="termos-btn" id="termos-btn">Termos e Condições de uso</span></p>
          <button disabled name="submit" class="btn" type="submit" id="btn">Logar</button>
        </form>
        <form id="form_sem_atendimento" class="hidden" method="POST" action="authorized.php">
          <input type="hidden" name="tipo1" value="ps">
          <div>
            <i class="fa-solid fa-key"></i>
            <input type="text" name="senha_toten" id="senha_toten" data-js="senha_toten" placeholder="Senha Toten" required>
          </div>
          <div id='container-loading1' style="width: 100%; justify-content: center; align-items: center; display: flex ;">
            <img style="height: 5rem;" src="image/tube-spinner.svg" alt="">
          </div>
          <div style="width: 100% ; display:none ; flex-direction: column;" id="error1">
            <span style="font-size: 1rem; font-weight: 600; color:brown">Senha do Toten não encontrado</span>
            <span style="font-size: 0.9rem; font-weight: 600; color:brown">Tente Novamente</span>
          </div>
          <div style="width: 100%; display:none" id="input_disable1">
            <div>
              <input type="hidden" name="mmac" value="nologado">
            </div>
            <div>
              <i class="fa-solid fa-user"></i> <input disabled type="text" name="nome" id="nome" data-js="nome" placeholder="Nome Completo" required>
            </div>
            <div>
              <i class="fas fa-envelope"></i> <input disabled type="email" name="email" id="email" data-js="email" placeholder="E-mail" required>
            </div>
            <div>
              <i class="fa-regular fa-credit-card"></i> <input disabled type="text" name="cpf" id="cpf" data-js="cpf" placeholder="CPF" required>
            </div>
            <div>
              <i class="fa-solid fa-phone-flip"></i> <input disabled type="text" name="tel" id="tel" data-js="tel" placeholder="Telefone" required>
            </div>
            <div>
              <i class="fa-solid fa-calendar-days"></i> <input disabled type="text" placeholder="Data Nascimento" onfocus="this.type='date'" onblur="if (!this.value) this.type='text'" name="data_nascimento" id="data_nascimento" data-js="data_nascimento" placeholder="Data de Nascimento" required>
            </div>
            <div>

            </div>
          </div>
          <p><input type="checkbox" name="" id="" required> Aceito os <span class="termos-btn" id="termos-btn1">Termos e Condições de uso</span></p>
          <button disabled name="submit" class="btn" type="submit" id="btn_logar">Logar</button>
        </form>
        <h3 id="selecione" class="hidden">Selecione o seu tipo de Paciente</h2>
      </div>
    </div>
  </div>
  </div>

  <script>
    const pacienteComAtendimento = document.getElementById('paciente_com_atendimento');
    const pacienteSemAtendimento = document.getElementById('paciente_sem_atendimento');
    const formComAtendimento = document.getElementById('form_com_atendimento');
    const formSemAtendimento = document.getElementById('form_sem_atendimento');
    const selecione = document.getElementById('selecione');
    const preencha = document.getElementById('preencha');

    if (!pacienteComAtendimento.checked && !pacienteSemAtendimento.checked) {
      selecione.classList.remove('hidden');
    }

    pacienteComAtendimento.addEventListener('change', function() {
      if (pacienteComAtendimento.checked) {
        formComAtendimento.classList.remove('hidden');
        formSemAtendimento.classList.add('hidden');
        selecione.classList.add('hidden');
        preencha.classList.remove("hidden")

      }
    });

    pacienteSemAtendimento.addEventListener('change', function() {
      if (pacienteSemAtendimento.checked) {
        formSemAtendimento.classList.remove('hidden');
        formComAtendimento.classList.add('hidden');
        selecione.classList.add('hidden');
        preencha.classList.remove("hidden")
      }
    });

    const masks = {
      cpf(value) {
        return value
          .replace(/\D/g, '')
          .replace(/(\d{3})(\d)/, '$1.$2')
          .replace(/(\d{3})(\d)/, '$1.$2')
          .replace(/(\d{3})(\d{1,2})/, '$1-$2')
          .replace(/(-\d{2})\d+?$/, '$1')
      },

      cpf1(value) {
        return value
          .replace(/\D/g, '')
          .replace(/(\d{3})(\d)/, '$1.$2')
          .replace(/(\d{3})(\d)/, '$1.$2')
          .replace(/(\d{3})(\d{1,2})/, '$1-$2')
          .replace(/(-\d{2})\d+?$/, '$1')
      },

      tel(value) {
        return value
          .replace(/\D/g, '')
          .replace(/(\d{2})(\d)/, '($1) $2')
          .replace(/(\d{4})(\d)/, '$1-$2')
          .replace(/(\d{4})-(\d)(\d{4})/, '$1$2-$3')
          .replace(/(-\d{4})\d+?$/, '$1')

      },
      nome(value) {
        value = value.replace(/\d/g, '');
        value = value.replace(/[^\w\sÀ-ú]/g, '');
        value = value.toLowerCase().replace(/(?:^|\s)\S/g, function(a) {
          return a.toUpperCase();
        });
        return value;
      },
      numero_atend(value) {
        value = value.replace(/\D/g, '');
        value = value.slice(0, 8);
        return value;
      },

      senha_toten(value) {
        // value = value.replace(/\D/g, '');
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

    let timeoutId;
    const loadingIndicator = document.getElementById('container-loading');
    const input_disable = document.getElementById('input_disable')
    input_disable.style.display = 'none'
    loadingIndicator.style.display = 'none';

    const numero_atend = document.getElementById('numero_atend')
    const error = document.getElementById('error')

    document.getElementById('numero_atend').addEventListener('input', function() {
      clearTimeout(timeoutId);
      timeoutId = setTimeout(() => {
        if (numero_atend.value.length === 7 || numero_atend.value.length === 8) {
          error.style.display = "none"
          input_disable.style.display = "none"
          const ap = '<?php echo $_GET["ap"]; ?>';
          const id = '<?php echo $_GET["id"]; ?>';
          const valornumero_atend = numero_atend.value;
          loadingIndicator.style.display = 'block';
          const xhr = new XMLHttpRequest();
          xhr.open('POST', 'verificarpaciente.php', true);
          xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          xhr.onreadystatechange = function() {
            loadingIndicator.style.display = 'none';
            if (xhr.readyState === 4 && xhr.status === 200) {
              const response = JSON.parse(xhr.responseText);
              if (response.logado) {
                const form = document.createElement('form');
                form.method = 'post';
                form.action = 'authorized.php';
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
                inputTipo.value = 'com';
                form.appendChild(inputTipo);

                const tipo_1 = document.createElement('input');
                tipo_1.type = 'hidden';
                tipo_1.name = 'tipo1';
                tipo_1.value = 'ps';
                form.appendChild(tipo_1);

                const inputNumero_atend = document.createElement('input');
                inputNumero_atend.type = 'hidden';
                inputNumero_atend.name = 'numero_atend';
                inputNumero_atend.value = valornumero_atend;
                form.appendChild(inputNumero_atend);

                document.body.appendChild(form);
                form.submit();
                // console.log("aa")
              } else {
                if (response.success) {
                  error.style.display = "flex"
                } else {
                  input_disable.style.display = 'block'
                  document.getElementById('cpf1').disabled = false;
                  document.getElementById('email_1').disabled = false;
                  document.getElementById('data_nasc').disabled = false;
                  document.getElementById("btn").disabled = false;
                }
              }
            }

          };
          xhr.send('numero_atend=' + encodeURIComponent(valornumero_atend) + '&pa=' + encodeURIComponent("com") + '&id=' + encodeURIComponent(id));
        }
      }, 1000);
    });

    const form_order = document.getElementById("form_order")
    const loadingIndicator1 = document.getElementById('container-loading1');
    const input_disable1 = document.getElementById('input_disable1');
    const error1 = document.getElementById('error1')
    // const btn_logar = document.getElementById('btn_logar')
    loadingIndicator1.style.display = 'none'
    document.getElementById('senha_toten').addEventListener('input', function() {
      clearTimeout(timeoutId);
      timeoutId = setTimeout(() => {
        console.log('tmnc')
        if (senha_toten.value.length === 6 || senha_toten.value.length === 8) {
          error1.style.display = "none"
          input_disable1.style.display = "none"
          const ap = '<?php echo $_GET["ap"]; ?>';
          const id = '<?php echo $_GET["id"]; ?>';
          const valorsenha_toten = senha_toten.value;
          loadingIndicator1.style.display = 'block';
          const xhr = new XMLHttpRequest();
          xhr.open('POST', 'verificarpaciente.php', true);
          xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          xhr.onreadystatechange = function() {
            loadingIndicator1.style.display = 'none';
            if (xhr.readyState === 4 && xhr.status === 200) {
              const response = JSON.parse(xhr.responseText);
              if (response.logado) {
                const form = document.createElement('form');
                form.method = 'post';
                form.action = 'authorized.php';
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
                inputTipo.value = 'sem';
                form.appendChild(inputTipo);

                const tipo_1 = document.createElement('input');
                tipo_1.type = 'hidden';
                tipo_1.name = 'tipo1';
                tipo_1.value = 'ps';
                form.appendChild(tipo_1);

                const inputSenha_toten = document.createElement('input');
                inputSenha_toten.type = 'hidden';
                inputSenha_toten.name = 'senha_toten';
                inputSenha_toten.value = valorsenha_toten;
                form.appendChild(inputSenha_toten);
                document.body.appendChild(form);
                form.submit();
              } else {
                if (response.success) {
                  error1.style.display = "flex"
                } else {
                  input_disable1.style.display = 'block'
                  document.getElementById('cpf').disabled = false;
                  document.getElementById('senha_toten').disabled = false;
                  document.getElementById('nome').disabled = false;
                  document.getElementById('email').disabled = false;
                  document.getElementById('tel').disabled = false;
                  document.getElementById('data_nascimento').disabled = false;
                  document.getElementById("btn_logar").disabled = false;

                }
              }

            }

          };
          xhr.send('senha_toten=' + encodeURIComponent(valorsenha_toten) + '&pa=' + encodeURIComponent('sem') + '&id=' + encodeURIComponent(id));
        }
      }, 1000);
    });





    const nome = document.getElementById('nome')
    const cpf = document.getElementById('cpf');
    const cpf1 = document.getElementById('cpf1')
    cpf1.addEventListener('input', () => {
      let strCPF = cpf1.value.replace('.', '').replace('.', '').replace('-', '');
      if (validarCPF(strCPF) === false) {
        cpf1.setCustomValidity("Preencha um CPF válido");
      } else {
        cpf1.setCustomValidity("");
      }
    })

    cpf.addEventListener('input', () => {
      let strCPF = cpf.value.replace('.', '').replace('.', '').replace('-', '');
      if (validarCPF(strCPF) === false) {
        cpf.setCustomValidity("Preencha um CPF válido");
      } else {
        cpf.setCustomValidity("");
      }
    })

    function validarCPF(cpf) {
      cpf = cpf.replace(/[^\d]+/g, '');
      if (cpf == '') return false;
      // Elimina CPFs invalidos conhecidos	
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

    const tel = document.getElementById('tel');
    tel.addEventListener('input', () => {
      let telValue = tel.value.replace('(', '').replace(')', '').replace('-', '').replace(' ', '').replace(' ', '');
      if (TestaTel(telValue) === false) {
        tel.setCustomValidity("Preencha um telefone válido");
      } else {
        tel.setCustomValidity("");
      }

    })

    function TestaTel(tel) {
      if (tel.length < 11 || tel == 12345678900 || tel == 11234567890 || tel == 11111111111 || tel == 22222222222 || tel == 33333333333 || tel == 44444444444 || tel == 55555555555 || tel == 66666666666 || tel == 77777777777 || tel == 88888888888 || tel == 99999999999) {
        return false;
      } else {
        return true;
      }
    }

    const form = document.getElementById('form');
    const btn = document.getElementById('btn');
    const btn1 = document.getElementById('btn1');
    const loading = document.getElementById('loading');
    const termosBtn = document.getElementById('termos-btn');
    const termosBtn1 = document.getElementById('termos-btn1')
    const termo = document.getElementById('termo');
    const overlay = document.getElementById('termo-over');
    const closeDiv = document.getElementById('closeDiv');
    const closeBtn = document.getElementById('closeBtn');

    termosBtn.addEventListener('click', () => {
      termo.style.display = 'block';
      overlay.style.display = 'block';
      closeDiv.style.display = 'block';
    })


    termosBtn1.addEventListener('click', () => {
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