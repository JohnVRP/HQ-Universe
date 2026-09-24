-- Adiciona suporte à foto de perfil.
ALTER TABLE usuarios
  ADD COLUMN IF NOT EXISTS foto VARCHAR(255) NULL AFTER telefone;
