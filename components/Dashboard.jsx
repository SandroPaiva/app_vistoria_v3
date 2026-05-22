import React from "react";
import "../styles/global.css";

const Dashboard = () => {
  // Mock de dados baseado nos KPIs exigidos
  const kpis = {
    veiculosCadastrados: 1250,
    vistoriasAndamento: 15,
    vistoriasConcluidas: 840,
    vistoriasCanceladas: 12,
  };

  return (
    <div>
      <nav className="navbar">
        <div className="container">
          <div style={{ fontWeight: 700, fontSize: "20px" }}>
            {/* O logo original Pilkington seria inserido aqui */}
            PILKINGTON VISTORIAS
          </div>
          <div>
            <button className="btn-primary">Nova Vistoria</button>
          </div>
        </div>
      </nav>

      <main className="container" style={{ marginTop: "100px" }}>
        <h1 style={{ color: "var(--color-dark)", fontSize: "32px" }}>
          Dashboard Operacional
        </h1>

        <div
          style={{
            display: "grid",
            gridTemplateColumns: "repeat(4, 1fr)",
            gap: "20px",
            marginTop: "20px",
          }}
        >
          <div
            style={{
              background: "var(--color-white)",
              padding: "20px",
              boxShadow: "0 1px 4px rgba(0,0,0,0.15)",
            }}
          >
            <h3 style={{ margin: 0, color: "var(--color-dark-mid)" }}>
              Veículos Cadastrados
            </h3>
            <p
              style={{
                fontSize: "24px",
                fontWeight: "bold",
                color: "var(--color-dark)",
              }}
            >
              {kpis.veiculosCadastrados}
            </p>
          </div>

          <div
            style={{
              background: "var(--color-white)",
              padding: "20px",
              boxShadow: "0 1px 4px rgba(0,0,0,0.15)",
            }}
          >
            <h3 style={{ margin: 0, color: "var(--color-dark-mid)" }}>
              Vistorias em Andamento
            </h3>
            <p
              style={{
                fontSize: "24px",
                fontWeight: "bold",
                color: "var(--color-primary)",
              }}
            >
              {kpis.vistoriasAndamento}
            </p>
          </div>

          <div
            style={{
              background: "var(--color-white)",
              padding: "20px",
              boxShadow: "0 1px 4px rgba(0,0,0,0.15)",
            }}
          >
            <h3 style={{ margin: 0, color: "var(--color-dark-mid)" }}>
              Vistorias Concluídas
            </h3>
            <p style={{ fontSize: "24px", fontWeight: "bold", color: "green" }}>
              {kpis.vistoriasConcluidas}
            </p>
          </div>

          <div
            style={{
              background: "var(--color-white)",
              padding: "20px",
              boxShadow: "0 1px 4px rgba(0,0,0,0.15)",
            }}
          >
            <h3 style={{ margin: 0, color: "var(--color-dark-mid)" }}>
              Vistorias Canceladas
            </h3>
            <p
              style={{
                fontSize: "24px",
                fontWeight: "bold",
                color: "var(--color-primary-dark)",
              }}
            >
              {kpis.vistoriasCanceladas}
            </p>
          </div>
        </div>
      </main>
    </div>
  );
};

export default Dashboard;
