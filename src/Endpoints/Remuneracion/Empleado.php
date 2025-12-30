<?php

namespace Jsanbae\LaudusAPIPHP\Endpoints\Remuneracion;

use Jsanbae\LaudusAPIPHP\APIBase;

class Empleado extends APIBase 
{
    protected $fields = [
        "employeeId",
        "firstName",
        "lastName1",
        "lastName2",
        "VATId",
        "gender",
        "department",
        "email",
        "extension",
        "homePhone",
        "mobile",
        "address",
        "county",
        "zipCode",
        "city",
        "state",
        "birthDate",
        "contractStartDate",
        "contractType",
        "contractTerminationDate",
        "contractTerminationType.code",
        "contractTerminationType.description",
        "contractExpirationDate",
        "type",
        "AFP.AFPId",
        "AFP.previredId",
        "AFP.name",
        "unemploymentInsuraceAFP.AFPId",
        "unemploymentInsuraceAFP.previredId",
        "unemploymentInsuraceAFP.name",
        "healthPlan.isapre.isapreId",
        "healthPlan.isapre.previredId",
        "healthPlan.isapre.name",
        "healthPlan.planType",
        "healthPlan.planAmount",
        "healthPlan.planAmountUF",
        "healthPlan.contractNumber",
        "dependentsStandard",
        "dependentsWithDisabilities",
        "amountPerDepedent",
        "paymentType.code",
        "paymentType.description",
        "accountNumber",
        "countryOfOrigin",
        "notes",
        "createdBy.userId",
        "createdBy.name",
        "createdAt",
        "modifiedBy.userId",
        "modifiedBy.name",
        "modifiedAt",
        "workingDayType",
        "workingDaysPerMonth",
        "workingDaysPerWeek",
        "profession.code",
        "profession.description",
        "degree.code",
        "degree.description",
        "degreeDate",
        "qualification.code",
        "qualification.description",
        "contractualSalary",
        "hasAccessToWebPortal",
        "holidaysPerYear",
        "restrictedAccess",
        "heavyWorkDescription",
        "progressiveHolidaysDateFrom",
        "disabilityType",
        "youngEmployeeBenefit",
        "youngEmployeeBenefitDateTo"
    ];

    public function __construct(string $_token)
    {
        parent::__construct($_token);
    }

    protected function getEndpoint(): string
    {
        return 'https://api.laudus.cl/hr/employees/';
    }

    protected function listEndpoint(): string
    {
        return 'https://api.laudus.cl/hr/employees/list';
    }

    protected function createEndpoint(): string
    {
        return '';
    }

    protected function deleteEndpoint(): string
    {
        return '';
    }

}