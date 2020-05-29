IF OBJECT_ID(N'TMP_SaldosCuotas', N'U') IS NOT NULL
    DROP TABLE dbo.TMP_SaldosCuotas;

SELECT C.Id,
       MIN(   CASE
                  WHEN CC.Cancelada = 0 THEN
                      CC.Vencimiento1
                  ELSE
                      '2050-01-01'
              END
          ) AS PrimerVencimientoImpago, -- tomo solo las no canceladas
       MIN(   CASE
                  WHEN CC.Cancelada = 0 THEN
                      CC.Cuota
                  ELSE
                      9999
              END
          ) AS PrimerCuotaImpaga,       -- tomo solo las no canceladas
       MAX(CC.Vencimiento1) AS UltimoVencimiento,
       MAX(CC.FechaCancela) AS FechaUltimoPago,
       SUM(   CASE
                  WHEN CC.Cancelada = 0 THEN
                      1
                  ELSE
                      0
              END
          ) AS CuotasImpagas,
       SUM(CC.Capital) AS Capital,
       SUM(CC.Interes) AS Interes,
       SUM(CC.Cargo1 + CC.Cargo2 + CC.Cargo3 + CC.Cargo4 + CC.Cargo5) AS CargosProrrateados,
       SUM(   CASE
                  WHEN CC.Cancelada = 0
                       AND CC.Vencimiento1 < GETDATE() THEN
                      CC.Saldo
                  ELSE
                      0
              END
          ) AS SaldoVencido,
       SUM(CC.Saldo) AS SaldoTotal,
       SUM(CC.CapitalPago) AS CobranzaCapital,
       SUM(CC.InteresPago) AS CobranzaInteres,
       SUM(CC.Cargo1Pago + CC.Cargo2Pago + CC.Cargo3Pago + CC.Cargo4Pago + CC.Cargo5Pago) AS CobranzaCargosProrrateados,
       SUM(CC.CapitalPago + CC.InteresPago + CC.Cargo1Pago + CC.Cargo2Pago + CC.Cargo3Pago + CC.Cargo4Pago
           + CC.Cargo5Pago
          ) AS CobranzaTotal,
       ISNULL(
       (
           SELECT SUM(PA.Punitorios + PA.Cargo6 + PA.Cargo7 + PA.Cargo8 + PA.Cargo9)
           FROM dbo.Pagos P
               INNER JOIN dbo.PagosAplicacion PA
                   ON PA.PagoId = P.Id
               INNER JOIN dbo.CreditosCuotas CC
                   ON CC.Id = PA.CuotaId
               INNER JOIN dbo.Transacciones T
                   ON T.Id = P.TransaccionId
           WHERE T.Baja = 0
                 AND CC.CreditoId = C.Id
       ),
       0
             ) AS CobranzaPunitorios,
       ISNULL(
       (
           SELECT SUM(NCA.Capital + NCA.Interes + NCA.Cargo1 + NCA.Cargo2 + NCA.Cargo3 + NCA.Cargo4 + NCA.Cargo5
                      + NCA.Cargo6 + NCA.Cargo7 + NCA.Cargo8 + NCA.Cargo9 + NCA.Punitorios
                     )
           FROM dbo.NotasCredito NC
               INNER JOIN dbo.NotasCreditoAplicacion NCA
                   ON NCA.NotaCreditoId = NC.Id
               INNER JOIN dbo.CreditosCuotas CC
                   ON CC.Id = NCA.CuotaId
               INNER JOIN dbo.Transacciones T
                   ON T.Id = NC.TransaccionId
           WHERE NC.EsFiscal = 0
                 AND T.Baja = 0
                 AND CC.CreditoId = C.Id
       ),
       0
             ) AS NotasCredito
INTO dbo.TMP_SaldosCuotas
FROM dbo.Creditos C
    INNER JOIN dbo.CreditosCuotas CC
        ON CC.CreditoId = C.Id
WHERE C.EstadoId IN ( 5, 10, 99 )
GROUP BY C.Id;


SELECT CASE WHEN S.EmpresaId = 1 then 'ARG$' else 'FINADI' END AS 'Origen'	 
	  ,REPLACE(LTRIM(RTRIM(P.[Nombre])),',','') as Nombre
	  ,P.[Documento]
	  ,PL.[Nombre] as NombrePlan
	  ,C.[Numero] as Credito
	  ,convert(varchar,[FechaPrevisionado],103) as 'Fecha Previsionado'
	  ,CASE
           WHEN C.EstadoId = 99 THEN
               0
           ELSE
               CASE
                   WHEN DATEDIFF(MONTH, TSC.PrimerVencimientoImpago, GETDATE()) < 0 THEN
                       0
                   ELSE
                       DATEDIFF(MONTH, TSC.PrimerVencimientoImpago, GETDATE())
               END
       END AS VectorMora
	  ,convert(varchar,[FechaUltimoPago],103) as 'F.Ult.Pago'
	  ,[CuotasImpagas] as 'Cuotas Impagas'
	  ,[SaldoVencido] as 'Saldo Venc.'
	  ,[SaldoTotal] as 'Saldo Total'
	  ,C.[Capital]
	  ,[Interes]
	  ,TSC.CargosProrrateados as 'Cargos'
	  ,TSC.CobranzaTotal as Cobranza
	  ,[CobranzaCapital] as 'Cobranza Capital'
	  ,[CobranzaInteres] as 'Cobranza Interes'
	  ,TSC.CobranzaCargosProrrateados as 'Cobranza Cargos'
	  ,TSC.CobranzaPunitorios as Punitorios
	  ,convert(varchar,[PrimerVencimientoImpago],103) as '1er Vto. Imp.'
	  ,convert(varchar,[PrimerCuotaImpaga],103) as '1er Cta. Imp.'
	  ,[ImporteCuota] as 'Imp. Cuota'
	  ,[Cuotas] as 'Total Ctas.'
	  ,TEC.Descripcion AS EstadoDescripcion
	  ,ISNULL(Cv.Nombre,'.') as 'Canal de Venta'
	  ,convert(varchar,C.[FechaIngreso],103) as 'Fecha Alta'
	  ,convert(varchar,C.[FechaEnvioEstudio],103) as 'Fecha Estudio'
	  ,ISNULL(EE.Descripcion, '.') as Tercerizado
	  , (
           SELECT TOP (1)
                  PT.Numero
           FROM dbo.PersonasTelefonos PT
           WHERE PT.PersonaId = P.Id
           ORDER BY PT.Orden
       ) AS Telefono
	  ,PD.Calle + ' ' + PD.Numero + ' ' + PD.Piso + ' ' + PD.Departamento AS Domicilio
	  ,[Localidad]
	  ,[Provincia]
	  ,CDS.ScoringVeraz as 'Score'
	  ,CASE WHEN [VerazMaxCuota] = '' THEN '0' ELSE ISNULL([VerazMaxCuota],0.0) END as 'Max Cuota'
	  ,(
           SELECT TOP (1)
                  CA.TomadoPor
           FROM dbo.CreditosAnalistas CA
           WHERE CA.CreditoId = C.Id
           ORDER BY CA.FechaToma DESC
       ) AS UltimoAnalista
	  ,TCV.Descripcion as 'Origen de la Operacion'
	  ,convert(varchar,[FechaLiquidacion],103) as 'Fecha Liquidacion'
	  ,TSC.NotasCredito as 'Importe NC'
	  ,TMP.Descripcion as 'Medio de Pago'
	  ,ISNULL(TDC.Descripcion, '') as 'Motivo Solicitud'
	  ,ISNULL([Responsable],'.') as Responsable
	  ,ISNULL(VC.Nombre, '.') as 'Venta'
	  ,convert(varchar,[UltimoVencimiento],103) as 'Ult. Vencimiento'
	  ,ISNULL(TSL.Descripcion,'.') as 'Situacion Laboral'
	  ,ISNULL(TSLA.Descripcion,'.') as 'Actividad Laboral'
	  ,ISNULL([Empleador],'.') as Empleador
	  ,ISNULL(PE.Cui,0) as Cuit
	  ,CASE WHEN PDC.Email = '' THEN '.' ELSE ISNULL(PDC.EMail, '.') END as Email
	  ,convert(varchar,[FechaNacimiento],103) as 'Fecha Nacimiento'
	  ,TCP.Descripcion as 'Tipo Cliente'
	  ,ISNULL(PE.DiaCobroId,0) as 'Dia Cobro'
	  ,'f'+ISNULL(PCB.CBU,'.') as CBU
	  ,ISNULL(EF.Descripcion, '.')  as Banco
	  ,ISNULL(PCBORIG.CBU, '.') as 'CBU Original'
	  ,ISNULL(EFORIG.Descripcion, '.') as 'Banco Original'
	  ,P.[CUI] as Cuil
	  ,PE.IngresoNeto AS Ingresos
	  ,[NosisScore] as 'Nosis Score'
	  ,[NosisSituacionBCRA] as 'Nosis Sit.BCRA'
	  ,[NosisReferenciasComerciales] as 'Nosis Ref. Comerciales'
	  ,NULL as 'Nosis NSE'
	  ,[NosisCuitEmpleador] as 'Nosis Empleador'
	  ,CASE WHEN [NumeroBeneficioAnses] = ' ' THEN '0' ELSE ISNULL([NumeroBeneficioAnses],'0') END as 'Numero Benef. ANSES'
	  ,ISNULL(AC.Numero,0) as 'Numero Acuerdo'
	  ,convert(varchar,(SELECT MIN(Vencimiento) FROM dbo.AcuerdosCuotas WHERE AcuerdoId = AC.Id AND Cancelada = 0),103) as 'Primer Vto. Acuerdo'
	  ,Case when [DenunciaActiva] = 1 then 'Si' else 'No' END as 'Denuncia Activa'
 FROM dbo.Personas P
    LEFT OUTER JOIN dbo.PersonasDatosContacto PDC
        ON PDC.PersonaId = P.Id
    INNER JOIN dbo.Creditos C
        ON C.PersonaId = P.Id
    INNER JOIN dbo.Sucursales S
        ON S.Id = C.SucursalId
    INNER JOIN dbo.CreditosDatosScoring CDS
        ON CDS.CreditoId = C.Id
    INNER JOIN dbo.TiposCalificacionPersona TCP
        ON TCP.Id = CDS.CalificacionPersonaId
    INNER JOIN dbo.CreditosDatosAdicionales CDA
        ON CDA.CreditoId = C.Id
    LEFT OUTER JOIN dbo.CreditosDatosConsulta CDC
        ON CDC.Id = C.ConsultaId
    LEFT OUTER JOIN dbo.ConsultasMotorSiisa CMS
        ON CMS.Id = CDC.ConsultaMotorId
    LEFT OUTER JOIN dbo.PersonasCuentasBanco PCB
        ON PCB.Id = CDA.CBUId
    LEFT OUTER JOIN dbo.EntidadesFinancieras EF
        ON EF.Codigo = SUBSTRING(PCB.CBU, 1, 3)
    LEFT OUTER JOIN dbo.PersonasCuentasBanco PCBORIG
        ON PCBORIG.Id = CDA.CBUOriginalId
    LEFT OUTER JOIN dbo.EntidadesFinancieras EFORIG
        ON EFORIG.Codigo = SUBSTRING(PCBORIG.CBU, 1, 3)
    LEFT OUTER JOIN dbo.TiposDestinoCredito TDC
        ON TDC.Id = CDA.MotivoSolicitudId
    LEFT OUTER JOIN dbo.TiposMedioPagoCredito TMP
        ON TMP.Id = C.MedioPagoId
    INNER JOIN dbo.TiposEstadoCredito TEC
        ON TEC.Id = C.EstadoId
    INNER JOIN dbo.CanalesVenta Cv
        ON Cv.Id = C.CanalVentaId
    INNER JOIN dbo.Planes PL
        ON PL.Id = C.PlanId
    INNER JOIN dbo.Productos PR
        ON PR.Id = PL.ProductoId
    LEFT OUTER JOIN dbo.EstudiosExternos EE
        ON EE.Id = C.EstudioId
    LEFT OUTER JOIN dbo.PersonasDomicilios PD
        ON PD.PersonaId = P.Id
           AND PD.EsPrincipal = 1
    LEFT OUTER JOIN dbo.PersonasEmpleos PE
        ON PE.PersonaId = P.Id
           AND PE.Orden = 1
    LEFT OUTER JOIN dbo.TiposSituacionLaboral TSL
        ON TSL.Id = PE.TipoSituacionLaboralId
    LEFT OUTER JOIN dbo.TiposSituacionLaboralActividad TSLA
        ON TSLA.Id = PE.TipoSituacionLaboralActividadId
    INNER JOIN dbo.TiposCanalVenta TCV
        ON TCV.Id = Cv.TipoCanalVentaId
    INNER JOIN dbo.TMP_SaldosCuotas TSC
        ON TSC.Id = C.Id
    LEFT OUTER JOIN dbo.ResponsableCreditoView RCV
        ON RCV.CreditoId = C.Id
    LEFT OUTER JOIN dbo.VentasCartera VC
        ON VC.Id = C.VentaCarteraId
    LEFT OUTER JOIN dbo.Acuerdos AC
        ON AC.Id = C.AcuerdoId AND AC.EstadoId != 4
WHERE C.EstadoId IN ( 5, 10, 99 );



