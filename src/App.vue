<template>
  <div />
</template>

<style>
.has-submenu {
  position: relative;
}

.sub-menu {
  display: none;
  position: absolute;
  left: 0;
  top: 100%;
  min-width: 200px;
  background-color: white;
  border: 1px solid #eee;
  z-index: 10;
  padding: 1rem;
  border-radius: 0.5rem;
  box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
}

.has-submenu:hover > .sub-menu {
  display: block;
}

.has-submenu:hover > a > i {
  transform: rotate(180deg);
}

.sub-menu .sub-menu {
    left: 100%;
    top: 0;
}
</style>
