ALTER TABLE expenses 
  ADD COLUMN attachment VARCHAR(255) NULL AFTER expenses_name_id;

ALTER TABLE payment 
  ADD COLUMN attachment VARCHAR(255) NULL AFTER payment_name_id;