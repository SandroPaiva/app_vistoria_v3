# BASE DE CONHECIMENTO — SITE PILKINGTON BRASIL
## Prompt de Configuração para GEM Gemini

---

## 1. IDENTIDADE DA MARCA

**Empresa:** Pilkington Brasil  
**Grupo:** NSG Group (Nippon Sheet Glass Co., Ltd.)  
**Sede global:** Tokyo, Japão  
**URL oficial Brasil:** https://www.pilkington.com/pt-br/br  
**Idioma do site:** Português Brasileiro (PT-BR)  
**Posicionamento:** Líder global em soluções de vidro e glazing para os segmentos Arquitetônico e Automotivo.  
**Tagline institucional:** *"Fazendo a diferença no mundo através da tecnologia do vidro."*  
**Marcas associadas no Brasil:** Blindex (www.blindex.com.br) | Cebrace (www.cebrace.com.br)

---

## 2. PALETA DE CORES OFICIAL

### Cores Primárias

| Nome | HEX | RGB | Uso Principal |
|------|-----|-----|---------------|
| Vermelho Pilkington | `#CC0000` | rgb(204, 0, 0) | Cor principal da marca, logotipo, CTAs, destaques, ícones ativos |
| Vermelho Profundo (variação) | `#A80000` | rgb(168, 0, 0) | Hover de botões, sombras vermelhas, estados pressionados |
| Branco | `#FFFFFF` | rgb(255, 255, 255) | Fundos de conteúdo, textos sobre fundo escuro |
| Preto Estrutural | `#000000` | rgb(0, 0, 0) | Texto principal, rodapé |

### Cores Secundárias / Neutros

| Nome | HEX | RGB | Uso Principal |
|------|-----|-----|---------------|
| Cinza Escuro (charcoal) | `#1A1A1A` | rgb(26, 26, 26) | Barra de navegação, header principal |
| Cinza Médio | `#3C3C3C` | rgb(60, 60, 60) | Texto de corpo secundário, subtítulos |
| Cinza Claro | `#6C6C6C` | rgb(108, 108, 108) | Texto auxiliar, captions, labels |
| Cinza de Superfície | `#F4F4F4` | rgb(244, 244, 244) | Fundos alternativos de seções, cards |
| Cinza Borda | `#DDDDDD` | rgb(221, 221, 221) | Divisores, bordas de tabelas, separadores |
| Cinza Hover | `#EEEEEE` | rgb(238, 238, 238) | Estado hover em itens de lista e menus |

### Cores de Estado e Suporte

| Nome | HEX | Uso |
|------|-----|-----|
| Azul Link | `#005A9C` | Links de texto, âncoras internas |
| Verde Sucesso | `#2E7D32` | Confirmações de formulário, badges |
| Amarelo Alerta | `#F9A825` | Alertas informativos, badges de destaque |
| Preto Overlay | `rgba(0,0,0,0.65)` | Overlays em banners, máscaras de imagem |

---

## 3. TIPOGRAFIA

### Famílias de Fontes

**Fonte Principal (Body):**  
- Família: `Arial, Helvetica Neue, Helvetica, sans-serif`  
- Uso: Parágrafos, descrições de produto, textos gerais  
- Característica: Fonte corporativa neutra, alta legibilidade em múltiplos tamanhos

**Fonte de Titulação:**  
- Família: `Arial Bold, Helvetica Neue Bold, sans-serif`  
- Uso: H1, H2, H3, títulos de seção, nomes de produto  
- Peso: `700` (Bold)

**Fonte de Interface / Navegação:**  
- Família: `Arial, sans-serif`  
- Uso: Itens de menu, breadcrumbs, labels de formulário, botões  
- Peso: `400` (Regular) e `700` (Bold) conforme contexto

### Escala Tipográfica (Desktop)

| Elemento | Tamanho | Peso | Line-height | Cor Padrão |
|----------|---------|------|-------------|------------|
| H1 (página) | 32px | 700 | 1.2 | `#1A1A1A` |
| H2 (seção) | 26px | 700 | 1.3 | `#1A1A1A` |
| H3 (subseção) | 20px | 700 | 1.4 | `#3C3C3C` |
| Body (parágrafo) | 15px | 400 | 1.6 | `#3C3C3C` |
| Small / Caption | 12px | 400 | 1.5 | `#6C6C6C` |
| Menu item | 13px | 700 | 1.0 | `#FFFFFF` (sobre fundo escuro) |
| Label / Badge | 11px | 700 | 1.0 | Variável |
| Botão CTA | 14px | 700 | 1.0 | `#FFFFFF` sobre `#CC0000` |

### Escala Tipográfica (Mobile)

| Elemento | Tamanho | Observação |
|----------|---------|------------|
| H1 | 24px | Reduzido para telas estreitas |
| H2 | 20px | — |
| Body | 14px | — |
| Menu mobile | 15px | Expanded/hamburger menu |

---

## 4. LAYOUT E ESTRUTURA DE PÁGINA

### Grid e Containers

- **Container máximo:** 1140px (largura máxima do conteúdo)
- **Gutter horizontal:** 20px (padding lateral nas laterais do container)
- **Sistema de grid:** 12 colunas (Bootstrap-like)
- **Breakpoints responsivos:**
  - Mobile: até 768px
  - Tablet: 769px – 1024px
  - Desktop: 1025px+

### Estrutura Global das Páginas

```
┌──────────────────────────────────────────────────────┐
│  TOP BAR (country/language selector + NSG logo)      │
│  Fundo: #1A1A1A | Texto: #FFFFFF                     │
├──────────────────────────────────────────────────────┤
│  HEADER / NAVIGATION                                  │
│  Logo Pilkington (esquerda) | Menu principal (centro) │
│  Fundo: #1A1A1A | Itens: #FFFFFF | Hover: #CC0000    │
├──────────────────────────────────────────────────────┤
│  HERO / BANNER PRINCIPAL (carousel)                   │
│  Imagem full-width com overlay escuro + CTA vermelho  │
│  Altura aprox: 400–500px                              │
├──────────────────────────────────────────────────────┤
│  QUICK LINKS / CARDS DE SEÇÃO                         │
│  Grid 4 colunas (desktop) | Fundo: #FFFFFF            │
│  Cards com imagem, título e links de sub-item         │
├──────────────────────────────────────────────────────┤
│  CONTEÚDO PRINCIPAL (variável por página)             │
│  Fundo alternado: #FFFFFF / #F4F4F4                   │
├──────────────────────────────────────────────────────┤
│  RODAPÉ                                               │
│  Fundo: #1A1A1A | Texto: #FFFFFF | Links: #DDDDDD    │
│  Social icons | Legal links | Copyright NSG           │
└──────────────────────────────────────────────────────┘
```

---

## 5. COMPONENTES DE INTERFACE

### Barra de Navegação (Header)

- **Posição:** Fixa ao topo da página
- **Fundo:** `#1A1A1A` (quase preto)
- **Logo:** Imagem PNG do logotipo Pilkington (vermelho e branco), ancorada à esquerda
- **Itens de menu:** Texto branco `#FFFFFF`, uppercase, fonte 13px bold
- **Dropdown submenus:** Fundo branco `#FFFFFF`, texto `#1A1A1A`, borda superior `#CC0000`
- **Hover nos itens:** Cor `#CC0000` ou sublinhado vermelho
- **Seletor de idioma/país:** Ícone de globo com lista de países (canto superior)
- **Mobile:** Menu hambúrguer, expandido com lista vertical

### Botões

| Tipo | Fundo | Texto | Borda | Hover |
|------|-------|-------|-------|-------|
| CTA Principal | `#CC0000` | `#FFFFFF` | none | `#A80000` |
| CTA Secundário | `transparent` | `#CC0000` | `2px solid #CC0000` | `#CC0000` bg, texto branco |
| Link/Ghost | transparent | `#005A9C` | none | sublinhado |
| Desabilitado | `#DDDDDD` | `#6C6C6C` | none | — |

- **Border-radius:** `0px` (botões quadrados, estilo corporativo)
- **Padding:** `10px 24px`
- **Texto:** Uppercase, bold, 13–14px

### Cards de Produto / Seção

- **Estrutura:** Imagem no topo (aspect ratio 16:9 aprox.), título, lista de links
- **Fundo:** `#FFFFFF`
- **Borda:** Nenhuma (shadow sutil: `0 1px 4px rgba(0,0,0,0.15)`)
- **Hover no card:** Elevação sutil de sombra
- **Título:** H3, bold, `#1A1A1A`
- **Links internos:** `#CC0000`, sem sublinhado por padrão, sublinhado no hover

### Carousel / Slider de Banner

- **Largura:** 100% da tela (full-width)
- **Overlay:** `rgba(0,0,0,0.40)` sobre a imagem
- **Texto no banner:** Branco `#FFFFFF`, alinhado à esquerda ou centralizado
- **Setas de navegação:** Ícones brancos sobre fundo semi-transparente
- **Indicadores (dots):** `#FFFFFF` inativo / `#CC0000` ativo

### Breadcrumbs

- **Separador:** `/` ou `>`
- **Cor dos links:** `#005A9C`
- **Cor do item ativo (página atual):** `#6C6C6C`, sem link
- **Tamanho:** 12px

### Formulários de Contato

- **Labels:** 13px, `#3C3C3C`, acima do campo
- **Inputs:** Borda `1px solid #DDDDDD`, focus `1px solid #CC0000`
- **Border-radius:** `0px`
- **Fundo do input:** `#FFFFFF`
- **Botão submit:** CTA Principal vermelho

### Rodapé

- **Fundo:** `#1A1A1A`
- **Título de coluna:** Branco `#FFFFFF`, uppercase, bold, 12px
- **Links:** Cinza claro `#AAAAAA`, sem sublinhado, hover branco
- **Ícones de redes sociais:** Brancos, pequenos (20–24px)
- **Redes sociais presentes:** Facebook, YouTube, Instagram, LinkedIn
- **Linha de copyright:** `#6C6C6C`, 11px — `© Copyright [ano] Nippon Sheet Glass Co., Ltd.`
- **Links legais:** Cookie Policy | Legal Notice | Privacy Policy | Terms & Conditions

---

## 6. ÍCONES E IMAGENS

### Estilo de Imagens

- Fotografias de alta qualidade de produtos de vidro (arquitetura, fachadas, interiores, carros)
- Imagens com foco em transparência, luz e reflexo do vidro
- Padrão editorial: pessoas em ambientes corporativos ou de instalação
- Resolução padrão de thumbnails: 210×140px (cards de produto)
- Banners: largura total, ~400–500px de altura

### Ícones

- Estilo: Simples, lineares (outline), sem preenchimento
- Cor padrão: `#CC0000` em destaque, `#6C6C6C` em estado neutro
- Ícones de produto e aplicação presentes nos menus de sub-navegação

---

## 7. NAVEGAÇÃO E ARQUITETURA DE INFORMAÇÃO

### Menu Principal (Nível 1)

1. **Sobre a empresa**
2. **Carreira**
3. **Categorias de Produtos**
4. **Automotivo**
5. **Lojas Pilkington**
6. **Contato**

### Submenu — Categorias de Produtos

- Pilkington DGU (Vidros Duplos)
- Pilkington Pyrostop® (Vidro Corta Fogo)
- Pilkington Profilit™
- Pilkington TG System™
- Pilkington Care™

### Submenu — Automotivo

- Automotivo Reposição (AGR)
- A Pilkington AGR
- Lojista
- Tecnologia (Nossos Vidros | Nossos Testes)
- Interatividade
- Você é (Clássico | Arrojado | Esportivo)
- Contato

### Submenu — Lojas Pilkington

- Quem Somos
- Produtos (Techglass | Sensor | Comfort | Multimedia | Personalité)
- Onde Encontrar / Conheça Nossas Lojas
- Serviços (Sistema ADAS)
- Pilkington Academy
- Interatividade
- Área do Segurado
- Contato

### Submenu — Sobre a empresa

- História
- Meio Ambiente (Política SGA | Política de EHS)
- Inclusão e Diversidade

---

## 8. TOM DE VOZ E LINGUAGEM

- **Idioma:** Português Brasileiro (PT-BR)
- **Tom:** Profissional, técnico, confiável e direto
- **Estilo:** Corporativo, mas acessível; evitar jargão excessivo
- **Verbos de ação nos CTAs:** "Saiba mais", "Entre em contato", "Conheça nossos produtos", "Solicite um orçamento"
- **Temas recorrentes:** Segurança, tecnologia, inovação, sustentabilidade, qualidade certificada
- **Marcas registradas e símbolos:** Sempre incluir `®`, `™` e `©` quando pertinente

---

## 9. REDES SOCIAIS E CANAIS DIGITAIS

| Canal | URL |
|-------|-----|
| Facebook | https://www.facebook.com/a.marca.e.pilkington |
| YouTube (AGR) | https://www.youtube.com/channel/UCy3RGyyB7175r_DAoH5Fmgg |
| Instagram | https://www.instagram.com/pilkingtonoficial/ |
| LinkedIn | https://www.linkedin.com/company/pilkington-brasil/ |

---

## 10. MARCAS PARCEIRAS E ECOSSISTEMA

| Marca | URL | Segmento |
|-------|-----|----------|
| Blindex | www.blindex.com.br | Vidros para construção/decoração |
| Cebrace | www.cebrace.com.br | Vidros planos nacionais |
| NSG Group | www.nsg.com | Holding global |

---

## 11. REGRAS DE USO DA MARCA (DIRETRIZES GERAIS)

1. O logotipo Pilkington deve sempre aparecer sobre fundo escuro ou branco, nunca sobre fundos coloridos que reduzam contraste.
2. O vermelho `#CC0000` é exclusivo da marca — não deve ser usado para estados de erro ou alertas negativos em interfaces digitais (use variações de laranja/amarelo nesses casos).
3. Não mesclar o logotipo com elementos gráficos sem aprovação da área de marketing.
4. O nome "Pilkington" em textos deve sempre ser escrito com inicial maiúscula.
5. Nomes de linha de produto com marcas registradas (Pyrostop®, Profilit™, TG System™, Care™) devem sempre incluir o símbolo correto.

---

## 12. ASPECTOS TÉCNICOS DO SITE

- **CMS/Plataforma:** Sitecore (NSG WCM — Web Content Management)
- **Caminho base dos assets CSS:** `/_externalBuilds/NSG.WCM.Pilkington.Core/css/`
- **Logo (desktop):** `/_externalBuilds/NSG.WCM.Pilkington.Core/css/img/rsz_pilkington_logo.png`
- **Logo (mobile):** `/_externalBuilds/NSG.WCM.Pilkington.Core/css/img/logo-mobile.png`
- **Logo NSG:** `/_externalBuilds/NSG.WCM.Pilkington.Core/css/img/nsg-logo-big.png`
- **Servidor de assets de documentos:** `assetmanager-ws.pilkington.com`
- **Design responsivo:** Sim (mobile-first, breakpoint principal em 768px)
- **Framework CSS:** Baseado em Bootstrap (grid de 12 colunas)
- **Consentimento de cookies:** Banner LGPD/GDPR com opções "Somente Essencial" e "Aceitar tudo"

---

## 13. EXEMPLO DE VARIÁVEIS CSS (PARA REPLICAÇÃO)

```css
:root {
  /* Cores da Marca */
  --color-primary:        #CC0000;
  --color-primary-dark:   #A80000;
  --color-primary-light:  #E53333;

  /* Neutros */
  --color-dark:           #1A1A1A;
  --color-dark-mid:       #3C3C3C;
  --color-mid:            #6C6C6C;
  --color-border:         #DDDDDD;
  --color-surface:        #F4F4F4;
  --color-white:          #FFFFFF;

  /* Links e Estados */
  --color-link:           #005A9C;
  --color-success:        #2E7D32;
  --color-warning:        #F9A825;

  /* Tipografia */
  --font-family-base:     Arial, 'Helvetica Neue', Helvetica, sans-serif;
  --font-size-base:       15px;
  --font-size-sm:         12px;
  --font-size-lg:         18px;
  --font-size-h1:         32px;
  --font-size-h2:         26px;
  --font-size-h3:         20px;
  --font-weight-normal:   400;
  --font-weight-bold:     700;
  --line-height-body:     1.6;

  /* Espaçamento */
  --spacing-xs:           4px;
  --spacing-sm:           8px;
  --spacing-md:           16px;
  --spacing-lg:           24px;
  --spacing-xl:           40px;
  --spacing-xxl:          64px;

  /* Contêiner */
  --container-max-width:  1140px;
  --container-padding:    20px;

  /* Bordas */
  --border-radius:        0px;
  --border-color:         #DDDDDD;

  /* Sombras */
  --shadow-card:          0 1px 4px rgba(0, 0, 0, 0.15);
  --shadow-nav:           0 2px 8px rgba(0, 0, 0, 0.30);
}
```

---

*Base de conhecimento gerada a partir da análise estrutural do site https://www.pilkington.com/pt-br/br e das diretrizes visuais da marca Pilkington Brasil / NSG Group.*  
*Última atualização: Maio 2026*
