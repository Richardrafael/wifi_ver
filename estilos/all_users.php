<?php

?>

<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #fff;
    margin: 0;
    padding: 0;
    width: 100vw;
    height: 100vh;
    align-items: center;
    display: flex;
    flex-direction: column;
  }

  .container-header {
    display: flex;
    justify-content: space-between;
    flex-direction: row;
    align-items: center;

  }

  .container {
    /* padding: 1rem; */
    width: 80%;
    display: flex;
    justify-content: center;
    align-items: center;


  }

  h1 {
    text-align: center;
    margin-bottom: 20px;
  }

  .grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
    width: 100%;
    place-items: center;
  }



  a {
    display: block;
    text-decoration: none;
    background-color: #057de8;
    color: #fff;
    text-align: center;
    padding: 20px;
    border-radius: 25px;
    width: 90%;
    font-size: 1.4rem;
    font-weight: 700;
  }

  .logo {
    width: 20rem;
  }

  .titulo {
    color: #000;
    font: 900;
    font-size: 2rem;
  }


  @media screen and (max-width: 768px) {
    .logo {
      width: 15rem;
    }

    .grid {
      grid-template-columns: repeat(1, 1fr);
    }

    .titulo {
      color: #000;
      font: 400;
      font-size: 2rem;
    }

    a {
      font-size: 1.5rem;
    }

  }
</style>