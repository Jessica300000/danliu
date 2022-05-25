<?php
header("Content-type: text/css");
?>

.text {
    text-align: left;
}

.button {
  background-color: #faceca;
  border-radius: 8px;
  border-color: black;
  border-bottom: 4px solid #b86761;
  box-shadow: 6px 6px 6px #999;
  color: black;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  user-select: none;
  transition: background 0.05s linear;
  transition: all .05s linear;
}

.button:hover {
  background-color: #b86761;
}

.button:active {
  box-shadow: 2px 2px 2px #777;
  border-bottom: 1px solid #b86761;
  transform: translateY(3px);
}

input[type=text], select {
  width: 20%;
  padding: 10px 15px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 8px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 5%;
  background-color: #faceca;
  color: black;
  padding: 10px 15px;
  margin: 8px 0;
  border: none;
  border-radius: 8px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #b86761;
}

body {
  background-image: url("BGI.gif");
  background-repeat: repeat-x;
  background-attachment: fixed;
  background-size: cover;
}


