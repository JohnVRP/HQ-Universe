-- Atualização opcional para bancos importados antes do checkout com entrega.
-- Execute no phpMyAdmin somente se desejar armazenar cada dado em coluna própria.

ALTER TABLE pedidos
  ADD COLUMN IF NOT EXISTS cep_entrega VARCHAR(8) NULL AFTER observacao,
  ADD COLUMN IF NOT EXISTS endereco_entrega VARCHAR(255) NULL AFTER cep_entrega,
  ADD COLUMN IF NOT EXISTS valor_frete DECIMAL(10,2) NOT NULL DEFAULT 0 AFTER endereco_entrega,
  ADD COLUMN IF NOT EXISTS prazo_entrega VARCHAR(80) NULL AFTER valor_frete;
