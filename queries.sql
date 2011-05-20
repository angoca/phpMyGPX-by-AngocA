// Funciones de soporte.

/* Esta funcion calcula la distancia entre dos puntos */
    drop function if exists distanceBtwPoints;
    delimiter @
    create function distanceBtwPoints (x1 int(11), y1 int(11), x2 int(11), y2 int(11))
        returns int
    begin
        declare ret int;
        set ret := sqrt(pow(y2 - y1, 2) + pow(x2 - x1, 2));
        return ret;
    end@
    delimiter ;

    /* Esta funcion devuelve el grado de inclinacion entre dos puntos */
    drop function if exists degreesFromPoint;
    delimiter @
    create function degreesFromPoint (x1 int(11), y1 int(11), x2 int(11), y2 int(11))
        returns float
    begin
        declare deltaY int;
        declare deltaX int;
        declare m float;
        declare radians float;
        declare degrees float;
        set deltaY := y2 - y1;
        set deltaX := x2 - x1;
        if (deltaX = 0) then
            set degrees := 0;
        else
            set m := deltaY / deltaX;
            set radians := atan(m);
            set degrees := degrees(radians);
        end if;
        # Case 1: 0 - 90
        if (deltaX >= 0 and deltaY >= 0) then
            set degrees := 90 - degrees;
        # Case 2: 270 - 360
        elseif (deltaX < 0 and deltaY >= 0) then
            set degrees := 270 - degrees;
        # Case 3: 180 - 270
        elseif (deltaX < 0 and deltaY < 0) then
            set degrees := 270 - degrees;
        # Case 4: 90 - 180
        elseif (deltaX >= 0 and deltaY < 0) then
            set degrees := 90 - degrees;
        end if;
        return degrees;
    end@
    delimiter ;

/* Esta funcion devuelve mayor que 0 si una foto esta entre el angulo dado. */
drop function if exists photoInRange;
delimiter @
create function photoInRange (degree float, direction float, delta float)
    returns tinyint
begin
    declare ret tinyint;
    set ret := 0;
    if (direction - delta <= 0) then
        if (0 <= degree and degree <= direction + delta) then
            set ret := 2;
        elseif (360 - (delta - direction) <= degree and degree <= 360) then
            set ret := 3;
        end if;
    elseif (direction + delta >= 360) then
        if (direction - delta <= degree and degree <= 360) then
            set ret := 4;
        elseif (0 <= degree and degree <= delta - (360 - direction)) then
            set ret := 5;
        end if;
    elseif (direction - delta <= degree and degree <= direction + delta) then
        set ret := 1;
    end if;
    return ret;
end@
delimiter ;


// API

##### Distancias a unas coordenadas dadas: getClosestPhotos
SET @x =-74082800;
SET @y =  4651208;
SELECT id, distanceBtwPoints(@x, @y, longitude, latitude) distance
FROM pois
ORDER BY distance;

##### Distancia mínima a una coordenada dada: getClosestPhoto
SET @x =-74082800;
SET @y =  4651208;
SELECT id, min(distance)
FROM (
    SELECT id, distanceBtwPoints(@x, @y, longitude, latitude) distance
    FROM pois
    GROUP BY distance, id
) distances;



##### Foto más cercana con una dirección dada: getClosestPhotoWithOrientation
SET @alpha =0; # entre 0, 360
SET @delta =10;
SET @x =-74082800;
SET @y =  4651208;
SELECT id, min(distance)
FROM (
    SELECT id, distanceBtwPoints(@x, @y, longitude, latitude) distance
    FROM pois
    WHERE photoInRange(image_dir, @alpha, @delta) > 0
    GROUP BY distance, id
) distances;

##### Fotos mas cercanas con una dirección dado: getQueryClosestPhotoWithOrientation



##### Fotos sobre un ángulo dado, retornando el angulo y la distancia: getClosestPhotosOverDirection
SET @alpha =315; # entre 0, 360
SET @delta =10;
SET @x =-74082800;
SET @y =  4651208;
SELECT id, degreesFromPoint(@x, @y, longitude, latitude) degree,
distanceBtwPoints(@x, @y, longitude, latitude) distance
FROM  pois
WHERE photoInRange(degreesFromPoint(@x, @y, longitude, latitude), @alpha, @delta) > 0
ORDER BY distance, degree;

##### Foto mas cercana sobre un angulo dado: getQueryClosestPhotoOverDirection
SET @alpha =315; # entre 0, 360
SET @delta =10;
SET @x =-74082800;
SET @y =  4651208;
SELECT id, min(distance)
FROM (
    SELECT id, distanceBtwPoints(@x, @y, longitude, latitude) distance
    FROM  pois
    WHERE photoInRange(degreesFromPoint(@x, @y, longitude, latitude), @alpha, @delta) > 0
) distances;



##### Fotos sobre ángulo dado apuntadas a una direccion dada: getClosestPhotosWithOrientationOverDirection
SET @postion =120; # entre 0, 360
SET @deltaPos =10;
SET @imgDir = 40;
SET @deltaImgDir = 30;
SET @x =-74088186;
SET @y =  4653732;
SELECT id, degreesFromPoint(@x, @y, longitude, latitude) degree, distanceBtwPoints(@x, @y, longitude, latitude) distance, image_dir
FROM  pois
WHERE photoInRange(degreesFromPoint(@x, @y, longitude, latitude), @postion, @deltaPos) > 0
AND photoInRange(image_dir, @imgDir, @deltaImgDir) > 0
ORDER BY distance, degree;

##### Foto más cercana sobre un ángulo dado apuntando a una direccion dada: getClosestPhotoWithOrientationOverDirection
SET @postion =120; # entre 0, 360
SET @deltaPos =10;
SET @imgDir = 40;
SET @deltaImgDir = 30;
SET @x =-74088186;
SET @y =  4653732;
SELECT id, min(distance)
FROM (
    SELECT id, distanceBtwPoints(@x, @y, longitude, latitude) distance
    FROM  pois
    WHERE photoInRange(degreesFromPoint(@x, @y, longitude, latitude), @postion, @deltaPos) > 0
    AND photoInRange(image_dir, @imgDir, @deltaImgDir) > 0
) distances;



##### Lista de fotos en un cuadro dado


##### Foto más cercana con una dirección dada sobre la misma recta (con un delta)

