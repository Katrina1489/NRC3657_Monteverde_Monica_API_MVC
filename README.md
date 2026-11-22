# Veterinaria Royal Pets — Mockup HTML + Tailwind

Mockup de sitio web para la **Veterinaria Royal Pets**, desarrollado con **HTML5 + Tailwind CSS 3.4 + JavaScript**.

---

## Descripción

Sitio web informativo y de contacto para una clínica veterinaria. Incluye:

- Página de inicio con hero.
- Secciones informativas: Nosotros, Servicios, Pacientes, Médicos.
- Footer con sedes, enlaces, redes sociales y newsletter.
- Diseño 100% responsive (móvil, tablet y desktop).
- Menú hamburguesa funcional en móvil.

---

## Tecnologías

- **HTML5** 
- **Tailwind CSS 3.4** 
- **JavaScript** — Menú hamburguesa e interactividad.
- **npm** — Gestión de dependencias.
- **Tailwind CLI** — Compilación de CSS.

---

## Requisitos

- **Node.js 18** o superior.
- **npm** (incluido con Node.js).

---

## Instalación y uso

```bash
# 1. Instalar dependencias
npm install

# 2. Compilar Tailwind 
npm run build

# 3. Compilar Tailwind 
npm run dev
```

Luego abre `src/index.html` en el navegador o con **Live Server** (extensión de VS Code).

---

## Estructura del proyecto

```
royal-pets/
├── dist/
│   └── output.css              # CSS compilado por Tailwind (no editable)
├── imagenes/                   # Recursos gráficos
├── src/
│   ├── index.html              # HTML principal
│   └── styles.css              # Fuente de Tailwind
├── package.json                # Configuración npm + scripts
├── package-lock.json           # Versiones exactas de dependencias
├── tailwind.config.js          # Diseño + fuentes personalizadas
└── README.md                   # Este archivo
```

---
