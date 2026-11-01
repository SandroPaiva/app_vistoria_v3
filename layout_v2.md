# BASE DE CONHECIMENTO — SITE PILKINGTON BRASIL
## Diretrizes UX/UI Modernizadas para Antigravity

---

# PRINCIPAIS ATUALIZAÇÕES

## Evolução Visual
- Design moderno e premium.
- Interface baseada em bordas arredondadas.
- Microinterações em todos os componentes clicáveis.
- Efeito de deslocamento suave (translateY) em menus, botões, cards e links.
- Sombras suaves e sensação de profundidade.
- Layout responsivo mobile-first.
- Foco em usabilidade, acessibilidade e conversão.

---

## NOVA IDENTIDADE VISUAL

### Cores Primárias

| Nome | HEX | Uso |
|--------|--------|--------|
| Verde Pilkington | #075E54 | Cor principal da marca |
| Verde Pilkington Dark | #05453D | Hover e estados pressionados |
| Verde Pilkington Light | #0A7D70 | Destaques e elementos secundários |
| Branco | #FFFFFF | Fundos e contraste |
| Preto Estrutural | #111111 | Textos e áreas institucionais |

### Neutros

| Nome | HEX |
|--------|--------|
| Cinza Escuro | #1A1A1A |
| Cinza Médio | #4A4A4A |
| Cinza Claro | #7A7A7A |
| Superfície | #F7F8F8 |
| Borda | #E5E7E7 |

---

## EXPERIÊNCIA DE INTERAÇÃO

### Hover Global

Todos os elementos interativos devem utilizar:

```css
transition: all .25s ease;
```

Ao passar o mouse:

```css
transform: translateY(-3px);
```

Aplicar em:

- Menu principal
- Submenus
- Botões
- Cards
- Ícones clicáveis
- Links destacados

---

## BOTÕES

### CTA Principal

```css
background: #075E54;
color: #FFFFFF;
border-radius: 12px;
padding: 14px 28px;
font-weight: 700;
box-shadow: 0 6px 18px rgba(7,94,84,.18);
```

Hover:

```css
background: #05453D;
transform: translateY(-3px);
box-shadow: 0 10px 24px rgba(7,94,84,.25);
```

### CTA Secundário

```css
background: transparent;
border: 2px solid #075E54;
color: #075E54;
border-radius: 12px;
```

---

## HEADER

### Navegação

- Header fixo.
- Efeito glassmorphism leve.
- Fundo: #FFFFFF com transparência.
- Blur: 12px.
- Sombra discreta.

### Menu

- Fonte sem serifa moderna.
- Espaçamento generoso.
- Hover:
  - Cor Verde Pilkington.
  - Movimento vertical de 3px.
  - Linha inferior animada.

### Dropdown

- Bordas arredondadas: 16px.
- Sombra suave.
- Destaque superior em Verde Pilkington.

---

## HERO SECTION

### Banner Principal

- Altura entre 600 e 700px.
- Imagens premium.
- Overlay escuro suave.
- CTA destacado em verde.
- Entrada com animação discreta.

---

## CARDS

### Novo padrão

```css
border-radius: 20px;
overflow: hidden;
background: #FFFFFF;
box-shadow: 0 8px 24px rgba(0,0,0,.08);
```

Hover:

```css
transform: translateY(-6px);
box-shadow: 0 16px 32px rgba(0,0,0,.12);
```

---

## FORMULÁRIOS

### Campos

```css
border-radius: 12px;
border: 1px solid #DCE2E2;
padding: 14px;
```

Focus:

```css
border-color: #075E54;
box-shadow: 0 0 0 4px rgba(7,94,84,.15);
```

---

## RODAPÉ

- Fundo: #111111.
- Links com hover em Verde Pilkington.
- Ícones com animação suave.
- Estrutura limpa e moderna.

---

## ACESSIBILIDADE

- Contraste mínimo WCAG AA.
- Estados de foco visíveis.
- Navegação por teclado.
- Componentes compatíveis com leitores de tela.

---

## ALTERAÇÕES DE NOMENCLATURA

Substituir em todo o projeto:

| Antigo | Novo |
|----------|----------|
| Vermelho Pilkington | Verde Pilkington |
| Vermelho Profundo | Verde Pilkington Dark |
| CTA Vermelho | CTA Verde |
| Destaque Vermelho | Destaque Verde |

---

## VARIÁVEIS CSS OFICIAIS

```css
:root {

  --color-primary: #075E54;
  --color-primary-dark: #05453D;
  --color-primary-light: #0A7D70;

  --color-dark: #111111;
  --color-dark-mid: #4A4A4A;
  --color-mid: #7A7A7A;

  --color-surface: #F7F8F8;
  --color-border: #E5E7E7;
  --color-white: #FFFFFF;

  --radius-sm: 8px;
  --radius-md: 12px;
  --radius-lg: 20px;
  --radius-xl: 28px;

  --shadow-sm: 0 4px 12px rgba(0,0,0,.08);
  --shadow-md: 0 8px 24px rgba(0,0,0,.10);
  --shadow-lg: 0 16px 32px rgba(0,0,0,.12);

  --transition: all .25s ease;
}
```

---

## DIRETRIZ FINAL PARA O ANTIGRAVITY

Todo o site deve transmitir:

- Tecnologia.
- Inovação.
- Sofisticação.
- Sustentabilidade.
- Segurança.
- Experiência premium.

Evitar aparência corporativa rígida baseada em elementos quadrados.
Priorizar curvas suaves, profundidade visual, microanimações e navegação intuitiva.
