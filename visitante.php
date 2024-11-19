<!DOCTYPE html>
<html lang="en">
<?php

session_start();
$_SESSION['id'] = $_GET['id'];          //user's mac address
$_SESSION['ap'] = $_GET['ap'];          //user ap
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
  <div class="close" id="closeDiv">
    <i style="cursor: pointer;" class="fas fa-times fa-2x" id="closeBtn"></i>
  </div>
  <div class="termo" id="termo">
    <?php include('components/termo.php'); ?>
  </div>
  <div class="termo-over" id="termo-over">
  </div>
  <div class="container">
    <div class="form" id="form">
      <h1 class="titulo">Visitante</h1>
      <?php include('components/noscript.php'); ?>
      <form method="POST" action="authorized.php">
        <input type="hidden" name="mmac" value="nologado">
        <input type="hidden" name="tipo1" value="vi">
        <input type="hidden" name="id" value="<?php echo $_SESSION['ap']; ?>" />
        <input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>" />
        <div><i class="fa-solid fa-user"></i> <input type="text" name="nome" id="nome" data-js="nome" placeholder="Nome Completo" required></div>
        <div><i class="fas fa-envelope"></i> <input type="email" name="email" id="email" data-js="email" placeholder="E-mail" required></div>
        <div><i class="fa-solid fa-phone-flip"></i> <input type="text" name="tel" id="tel" data-js="tel" placeholder="Telefone" required></div>
        <div><i class="fa-regular fa-credit-card"></i> <input type="text" name="cpf" id="cpf" data-js="cpf" placeholder="CPF" required></div>
        <div>
          <p><input type="checkbox" name="" id="" required> Aceito os <span class="termos-btn" id="termos-btn">Termos e Condições de uso</span></p>
        </div>
        <button name="submit" class="btn" type="submit" id="btn">Logar</button>
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
      }

    }

    document.querySelectorAll('input').forEach(($input) => {
      const field = $input.dataset.js
      $input.addEventListener('input', (e) => {
        e.target.value = masks[field](e.target.value)
      }, false)
    })

    const cpf = document.getElementById('cpf');
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

    const nome = document.getElementById('nome')
    nome.addEventListener('input', () => {});
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

    function TestaTel(tel) {
      if (tel.length < 11 || tel == 12345678900 || tel == 11234567890 || tel == 11111111111 || tel == 22222222222 || tel == 33333333333 || tel == 44444444444 || tel == 55555555555 || tel == 66666666666 || tel == 77777777777 || tel == 88888888888 || tel == 99999999999) {
        return false;
      } else {
        return true;
      }
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