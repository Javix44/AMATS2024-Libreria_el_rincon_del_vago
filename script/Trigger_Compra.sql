DELIMITER $$
CREATE TRIGGER Compra_Producto AFTER INSERT ON Compra
    FOR EACH ROW 
BEGIN
    -- Actualizar la cantidad de producto 
    UPDATE producto
    SET Stock = Stock + NEW.cantidad
    WHERE Idproducto = NEW.Idproducto;
END; $$
DELIMITER ;
